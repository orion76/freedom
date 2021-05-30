<?php

namespace Drupal\rate\Plugin;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Rate widget plugin manager.
 */
class RateWidgetManager extends DefaultPluginManager implements RateWidgetManagerInterface{


  /**
   * Constructs a new RateWidgetManager object.
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
    parent::__construct('Plugin/RateWidget', $namespaces, $module_handler, 'Drupal\rate\Plugin\RateWidgetInterface', 'Drupal\rate\Annotation\RateWidget');

    $this->alterInfo('rate_rate_widget_info');
    $this->setCacheBackend($cache_backend, 'rate_rate_widget_plugins');
  }

}
