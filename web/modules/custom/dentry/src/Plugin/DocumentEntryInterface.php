<?php

namespace Drupal\dentry\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Entity\EntityInterface;

/**
 * Defines an interface for Document entry plugins.
 */
interface DocumentEntryInterface extends PluginInspectionInterface {


  public function getEntries(EntityInterface $entity);

}
