<?php

namespace Drupal\freedom_edms\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;

/**
 * Provides an interface for defining Entry entities.
 *
 * @ingroup freedom_edms
 */
interface EdmsDentryInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Entry name.
   *
   * @return string
   *   Name of the Entry.
   */
  public function getName();

  /**
   * Sets the Entry name.
   *
   * @param string $name
   *   The Entry name.
   *
   * @return \Drupal\freedom_edms\Entity\EdmsDentryInterface
   *   The called Entry entity.
   */
  public function setName($name);

  /**
   * Gets the Entry creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Entry.
   */
  public function getCreatedTime();

  /**
   * Sets the Entry creation timestamp.
   *
   * @param int $timestamp
   *   The Entry creation timestamp.
   *
   * @return \Drupal\freedom_edms\Entity\EdmsDentryInterface
   *   The called Entry entity.
   */
  public function setCreatedTime($timestamp);

}
