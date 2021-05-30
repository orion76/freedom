<?php

namespace Drupal\dentry\Plugin;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\Entity\EntityInterface;

/**
 * Base class for Document entry plugins.
 */
abstract class DocumentEntryBase extends PluginBase implements DocumentEntryInterface {


  public function getEntries(EntityInterface $entity) {

  }

}
