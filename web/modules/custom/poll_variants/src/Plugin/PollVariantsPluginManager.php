<?php

namespace Drupal\poll_variants\Plugin;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Poll variants plugin plugin manager.
 */
class PollVariantsPluginManager extends DefaultPluginManager {


  /**
   * Constructs a new PollVariantsPluginManager object.
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
    parent::__construct('Plugin/PollVariants', $namespaces, $module_handler, 'Drupal\poll_variants\Plugin\PollVariantsPluginInterface', 'Drupal\poll_variants\Annotation\PollVariants');

    $this->alterInfo('poll_variants_poll_variants_plugin_info');
    $this->setCacheBackend($cache_backend, 'poll_variants_poll_variants_plugin_plugins');
  }

}
