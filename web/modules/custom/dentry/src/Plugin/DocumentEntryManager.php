<?php

namespace Drupal\dentry\Plugin;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Document entry plugin manager.
 */
class DocumentEntryManager extends DefaultPluginManager {


  /**
   * Constructs a new DocumentEntryManager object.
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
    parent::__construct('Plugin/DocumentEntry', $namespaces, $module_handler, 'Drupal\dentry\Plugin\DocumentEntryInterface', 'Drupal\dentry\Annotation\DocumentEntry');

    $this->alterInfo('dentry_document_entry_info');
    $this->setCacheBackend($cache_backend, 'dentry_document_entry_plugins');
  }

}
