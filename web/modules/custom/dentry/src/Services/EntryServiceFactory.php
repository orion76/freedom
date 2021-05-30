<?php

namespace Drupal\dentry\Services;

use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

class EntryServiceFactory {

  /** @var EntityTypeManagerInterface */
  private $entityTypeManager;

  /** @var PluginManagerInterface    */ 
  private $pluginManager;

  public function __construct(EntityTypeManagerInterface $entityTypeManager,PluginManagerInterface $pluginManager) {
    $this->entityTypeManager = $entityTypeManager;
    $this->pluginManager = $pluginManager;
  }


  public function create($entry_type, $operation_type) {
    $service = new EntryService(
      $this->entityTypeManager->getStorage($entry_type),
      $this->entityTypeManager->getStorage($operation_type),
      $this->pluginManager
    );
    
    return $service;
  }
}
