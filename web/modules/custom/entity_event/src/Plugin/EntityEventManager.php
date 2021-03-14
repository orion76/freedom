<?php

namespace Drupal\entity_event\Plugin;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Entity event plugin manager.
 */
class EntityEventManager extends DefaultPluginManager {


  /**
   * Constructs a new EntityEventManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/EntityEvent', $namespaces, $module_handler, 'Drupal\entity_event\Plugin\EntityEventInterface', 'Drupal\entity_event\Annotation\EntityEvent');

    $this->alterInfo('entity_event_entity_event_info');
    $this->setCacheBackend($cache_backend, 'entity_event_entity_event_plugins');
  }

}
