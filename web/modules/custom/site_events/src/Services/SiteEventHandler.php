<?php


namespace Drupal\site_events\Services;


use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\site_events\Entity\Handlers\SiteEventSubscriberStorageInterface;
use Drupal\site_events\Plugin\SiteEventPluginInterface;
use Drupal\site_events\Plugin\SiteSubscriberPluginInterface;
use Drupal\site_events\Plugin\SiteSubscriberPluginManagerInterface;


class SiteEventHandler implements SiteEventHandlerInterface {


    /** @var SiteEventSubscriberStorageInterface */
    private $subscriberStorage;

    /** @var PluginManagerInterface */
    private $subscriberPlugins;

    public function __construct(
        SiteSubscriberPluginManagerInterface $subscriberPlugins,
        EntityTypeManagerInterface $entityTypeManager
    ) {
        $this->subscriberPlugins = $subscriberPlugins;
        $this->subscriberStorage = $entityTypeManager->getStorage('site_event_subscriber');
    }

    public function handle(SiteEventPLuginInterface $event) {
        $data = $event->getData();
        $subscribers_configs = $this->subscriberStorage->loadSubscribers($event->getPluginId());
        foreach ($subscribers_configs as $subscriber_config) {
            /** @var $subscriber_config \Drupal\site_events\Entity\SiteEventSubscriberInterface */
            $subscriber_id = $subscriber_config->getSubscriberId();
            /** @var $subscriber SiteSubscriberPluginInterface */
            $subscriber = $this->subscriberPlugins->createInstance($subscriber_id);
            $subscriber->execute($data);
        }
    }

}
