<?php

namespace EXS\FeedsAWEBundle\Service;

use GuzzleHttp\Client;

/**
 * Class FeedsReader
 *
 * @package EXS\FeedsAWEBundle\Service
 */
class FeedsReader
{
    /**
     * @var \Memcached
     */
    private $memcached;

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var int
     */
    private $cacheTtl;

    /**
     * FeedsReader constructor.
     *
     * @param \Memcached $memcached
     * @param Client     $httpClient
     * @param int        $cacheTtl
     */
    public function __construct(\Memcached $memcached, Client $httpClient, $cacheTtl = 120)
    {
        $this->memcached = $memcached;
        $this->httpClient = $httpClient;
        $this->cacheTtl = $cacheTtl;
    }

    /**
     * @return array
     */
    public function getLivePerformers()
    {
        $cacheKey = $this->getCacheKey();

        if (
            (false === $performers = $this->memcached->get($cacheKey))
            || empty($performers)
        ) {
            $performers = $this->refreshLivePerformers();

            $this->memcached->set($cacheKey, $performers, $this->cacheTtl);
        }

        return $performers;
    }

    /**
     * @return array
     */
    private function refreshLivePerformers()
    {
        $performers = [];

        try {
            $response = $this->httpClient->get('http://live-cams-2.livejasmin.com/allonline/?site=jsm&psid=rabbit&campaign_id=34751&pstour=t1&psprogram=REVS&landing_page=freechat&image_count=5&image_size=full&flags=1&willingness=1&allmodels=0', [
                'headers' => ['Accept' => 'application/xml'],
                'timeout' => 10.0,
                'http_errors' => false,
            ]);

            if (200 === $response->getStatusCode()) {
                $responseContent = $response->getBody()->getContents();

                $content = new \SimpleXMLElement($responseContent);

                foreach ($content->xpath('category/performerinfo/performerid') as $performerid) {
                    $performers[] = (string)$performerid;
                }
            }
        } catch (\Exception $e) {
            $performers = [];
        }

        return $performers;
    }

    /**
     * @return string
     */
    private function getCacheKey()
    {
        return sprintf('AWELivePerformers');
    }
}
