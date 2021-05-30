<?php

namespace Drupal\dentry_test\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;

/**
 * Provides an interface for defining Operation test entities.
 *
 * @ingroup dentry_test
 */
interface OperationTestInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Operation test name.
   *
   * @return string
   *   Name of the Operation test.
   */
  public function getName();

  /**
   * Sets the Operation test name.
   *
   * @param string $name
   *   The Operation test name.
   *
   * @return \Drupal\dentry_test\Entity\OperationTestInterface
   *   The called Operation test entity.
   */
  public function setName($name);

  /**
   * Gets the Operation test creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Operation test.
   */
  public function getCreatedTime();

  /**
   * Sets the Operation test creation timestamp.
   *
   * @param int $timestamp
   *   The Operation test creation timestamp.
   *
   * @return \Drupal\dentry_test\Entity\OperationTestInterface
   *   The called Operation test entity.
   */
  public function setCreatedTime($timestamp);

}
