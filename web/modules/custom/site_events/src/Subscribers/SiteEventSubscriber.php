<?php

namespace Drupal\site_events\Subscribers;

use Drupal;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\site_events\Plugin\SiteEventPluginInterface;
use Drupal\site_events\Plugin\SiteEventPluginManager;
use Drupal\site_events\Plugin\SiteSubscriberPluginInterface;
use Drupal\site_events\Plugin\SiteSubscriberPluginManager;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use \Drupal\site_events\Entity\SiteEventSubscriberInterface as EntitySubscriberInterface;
use function str_replace;

class SiteEventSubscriber implements EventSubscriberInterface {


    /** @var EntityStorageInterface */
    private static $eventStorage;

    /** @var SiteSubscriberPluginManager */
    private $subscriberPlugins;

    /** @var SiteEventPluginManager */
    private $eventPlugins;

    private $subscriberStorage;

    public function __construct(
        SiteEventPluginManager $eventPlugins,
        SiteSubscriberPluginManager $subscriberPlugins,
        EntityTypeManagerInterface $entityTypeManager

    ) {
        $this->subscriberStorage = $entityTypeManager->getStorage('');
        $this->eventPlugins = $eventPlugins;
        $this->subscriberPlugins = $subscriberPlugins;
    }

    public function __call($name, $arguments) {
        $subscriber_id = str_replace('subscriber__', '', $name);
        $this->subscribe($arguments[0], $subscriber_id);
    }

    static function getStorage() {
        if (empty(self::$eventStorage)) {
            self::$eventStorage = Drupal::service('entity_type.manager')->getStorage('site_event_subscriber');
        }
        return self::$eventStorage;
    }

    public static function getSubscribedEvents() {
        $subscribers = [];
        /** @var $entityTypeManager \Drupal\Core\Entity\EntityTypeManagerInterface */

        if (FALSE === Drupal::hasContainer()) {
            return [];
        }

        $entityTypeManager = Drupal::service('entity_type.manager');
        /**
         * При установке модуля, storage для "site_event_subscriber" еще не создан,
         * поэтому пропускаем "подписку" при установке
         */
        if (FALSE === $entityTypeManager->hasHandler('site_event_subscriber', 'storage')) {
            return [];
        }

        $storage = $entityTypeManager->getStorage('site_event_subscriber');
        foreach ($storage->loadMultiple() as $subscriber_entity) {
            /** @var $subscriber_entity EntitySubscriberInterface */
            $method = "subscribe__" . $subscriber_entity->id();
            $subscribers[$subscriber_entity->getEventId()] = $method;
        }
        return $subscribers;
    }

    public function subscribe(Event $event, $subscriber_entity_id) {
        /** @var $event_plugin SiteEventPluginInterface */
        $subscriber_entity = $this->subscriberStorage->load($subscriber_entity_id);
        $event_plugin = $this->eventPlugins->createInstance($subscriber_entity->getEventId());
        /** @var $subscriber_plugin SiteSubscriberPluginInterface */
        $subscriber_plugin = $this->subscriberPlugins->createInstance($subscriber_entity->getSubscriberId());
        $subscriber_plugin->execute($event_plugin->getData($event));
    }
}
