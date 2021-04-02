<?php

namespace Drupal\site_events\Plugin\SiteSubscriber;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\site_events\Plugin\SiteEventPluginInterface;
use Drupal\site_events\Plugin\SiteSubscriberPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class EntityCreate
 *
 * @SiteSubscriber(
 *     id="drupal_log",
 *     label = "Drupal log"
 * )
 * @package Drupal\entity_event\Plugin\EntityAction
 */
class DrupalLog extends SiteSubscriberPluginBase implements SiteEventPluginInterface{

    /** @var LoggerChannelInterface */
    private $logger;

    public function __construct(array $configuration, $plugin_id, $plugin_definition, LoggerChannelInterface $logger) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->logger = $logger;
    }


    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('logger.channel.site_events')
        );
    }

    public function execute($entity) {
        /** @var $entity EntityInterface */
        $this->logger->info($entity->label());
    }



}
