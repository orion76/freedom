<?php

namespace Drupal\dentry\Services;

use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\dentry\EntryInterface;
use Drupal\dentry\OperationInterface;
use Drupal\dentry\Plugin\DocumentEntryInterface;

class EntryService implements EntryServiceInterface {

  /** @var ContentEntityStorageInterface */
  private $entryStorage;

  /** @var ContentEntityStorageInterface */
  private $operationStorage;

  /** @var PluginManagerInterface */
  private $pluginManager;

  public function __construct(ContentEntityStorageInterface $entryStorage,
                              ContentEntityStorageInterface $operationStorage,
                              PluginManagerInterface $pluginManager) {


    $this->entryStorage = $entryStorage;
    $this->operationStorage = $operationStorage;
    $this->pluginManager = $pluginManager;
  }


  public function createEntry(ConfigEntityInterface $debet,
                              ConfigEntityInterface $credit,
                              $subcontoDebet,
                              $subcontoCredit,
                              $value
  ) {
    $values = [
      'debet' => $debet->id(),
      'credit' => $credit->id(),

    ];

    $values += $subcontoDebet;
    $values += $subcontoCredit;

    $values['value'] = $value;

    /** @var $entity ContentEntityInterface */
    $entity = $this->entryStorage->create($values);

    return $entity;
  }

  public function createOperation(EntityInterface $document) {
    $values = [
      'name' => $document->label(),
      'document' => $document->id(),
    ];
    /** @var $entity OperationInterface */
    $entity = $this->operationStorage->create($values);
    return $entity;
  }

  public function doEntry(EntityInterface $entity) {
    /** @var $operation OperationInterface */
    $operation = $this->createOperation($entity);
    $plugin_id = $entity->getEntityTypeId() . ":" . $entity->bundle();
    /** @var $plugin DocumentEntryInterface */
    $plugin = $this->pluginManager->createInstance($plugin_id);
    $entries = $plugin->getEntries($entity);

    foreach ($entries as $entry) {
      /** @var $entry EntryInterface */
      $operation->addEntry($entry);
    }

    try {
      $operation->save();
    } catch (EntityStorageException $e) {
      /*
      * @TODO 
       * 
      */
    }
  }
}
