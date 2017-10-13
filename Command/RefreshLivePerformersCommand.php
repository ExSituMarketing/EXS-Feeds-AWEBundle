<?php

namespace EXS\FeedsAWEBundle\Command;

use EXS\FeedsAWEBundle\Service\FeedsReader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class RefreshLivePerformersCommand
 *
 * @package EXS\FeedsAWEBundle\Command
 */
class RefreshLivePerformersCommand extends ContainerAwareCommand
{
    /**
     * @var SymfonyStyle
     */
    private $style;

    /**
     * @var int
     */
    private $ttl;

    /**
     * @var FeedsReader
     */
    private $reader;

    /**
     * {@inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('feeds:awe:refresh-live-performers')
            ->setDescription('Reads AWE api and refreshes live performer ids in memcached.')
            ->addOption('ttl', null, InputOption::VALUE_OPTIONAL, 'Memcached entry\'s time to live.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->style = new SymfonyStyle($input, $output);

        if (null === $this->ttl = $input->getOption('ttl')) {
            $this->ttl = $this->getContainer()->getParameter('exs_feeds_awe.cache_ttl');
        }

        $this->reader = $this->getContainer()->get('exs_feeds_awe.feeds_reader');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $performers = $this->reader->refreshLivePerformers($this->ttl);

        if (0 < count($performers)) {
            $this->style->block([sprintf('Cache refreshed with %d performers.', count($performers))], null, 'info');
        } else {
            $this->style->block(['Impossible to get performers information.', 'Cache not refreshed.'], null, 'error');
        }
    }
}
