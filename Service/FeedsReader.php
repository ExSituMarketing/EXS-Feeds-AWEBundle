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
    private $defaultTtl;

    /**
     * FeedsReader constructor.
     *
     * @param \Memcached $memcached
     * @param Client     $httpClient
     * @param int        $defaultTtl
     */
    public function __construct(\Memcached $memcached, Client $httpClient, $defaultTtl = 300)
    {
        $this->memcached = $memcached;
        $this->httpClient = $httpClient;
        $this->defaultTtl = $defaultTtl;
    }

    /**
     * Returns an array of live performer ids.
     *
     * @return array
     */
    public function getLivePerformers()
    {
        if (
            (false === $performers = $this->memcached->get($this->getCacheKey()))
            || empty($performers)
        ) {
            $performers = $this->refreshLivePerformers();
        }

        return $performers;
    }

    /**
     * Requests live performers from AWE api, extracts the performer ids and set the result in cache.
     *
     * @param int $ttl
     *
     * @return array
     */
    public function refreshLivePerformers($ttl = null)
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

                foreach ($content->xpath('category/performerinfo/performerid') as $performerId) {
                    $performers[] = (string)$performerId;
                }
            }

            $this->memcached->set($this->getCacheKey(), $performers, $ttl ?: $this->defaultTtl);
        } catch (\Exception $e) {
            $performers = [];
        }

        return $performers;
    }

    /**
     * Returns the cache key.
     *
     * @return string
     */
    private function getCacheKey()
    {
        return sprintf('AWELivePerformers');
    }
}
