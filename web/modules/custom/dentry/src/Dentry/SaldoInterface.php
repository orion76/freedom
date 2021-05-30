<?php

namespace Drupal\dentry\Dentry;

use Drupal\Core\Entity\ContentEntityInterface;

interface SaldoInterface extends ContentEntityInterface{

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
}
