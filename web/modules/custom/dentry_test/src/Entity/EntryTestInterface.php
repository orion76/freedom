<?php

namespace Drupal\dentry_test\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;

/**
 * Provides an interface for defining Entry test entities.
 *
 * @ingroup dentry
 */
interface EntryTestInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Entry test name.
   *
   * @return string
   *   Name of the Entry test.
   */
  public function getName();

  /**
   * Sets the Entry test name.
   *
   * @param string $name
   *   The Entry test name.
   *
   * @return \Drupal\dentry\Entity\EntryTestInterface
   *   The called Entry test entity.
   */
  public function setName($name);

  /**
   * Gets the Entry test creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Entry test.
   */
  public function getCreatedTime();

  /**
   * Sets the Entry test creation timestamp.
   *
   * @param int $timestamp
   *   The Entry test creation timestamp.
   *
   * @return \Drupal\dentry\Entity\EntryTestInterface
   *   The called Entry test entity.
   */
  public function setCreatedTime($timestamp);

}
