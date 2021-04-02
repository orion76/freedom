<?php


namespace Drupal\site_events\Services;


use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\site_events\Plugin\SiteEventPluginManagerInterface;


class EntityEventService implements EntityEventServiceInterface {


    /** @var SiteEventHandlerInterface */
    private $eventHandler;

    /** @var PluginManagerInterface */
    private $pluginManager;

    public function __construct(SiteEventPluginManagerInterface $pluginManager, SiteEventHandlerInterface $eventHandler) {
        $this->pluginManager = $pluginManager;
        $this->eventHandler = $eventHandler;
    }

    public function dispatch($event_name, EntityInterface $entity) {
        $source = $entity->getEntityTypeId();
        /** @var $event \Drupal\site_events\Plugin\SiteEventPluginInterface */
        if($event_name==='update'){
            $n=0;
        }
        $event = $this->pluginManager->getEvent($source, $event_name);
        if (!is_null($event)) {
            $event->setData($entity);
            $this->eventHandler->handle($event);
        }
    }

}
