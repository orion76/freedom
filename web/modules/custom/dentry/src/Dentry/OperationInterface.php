<?php

namespace Drupal\dentry\Dentry;

use Drupal\Core\Entity\ContentEntityInterface;

interface OperationInterface extends ContentEntityInterface{

  /**
   * {@inheritdoc}
   */
  public function getName();

  /**
   * {@inheritdoc}
   */
  public function setName($name);

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime();

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp);

  public function getEntries();

  public function addEntry($entry);
}
