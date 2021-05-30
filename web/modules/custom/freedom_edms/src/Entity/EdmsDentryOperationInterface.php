<?php

namespace Drupal\freedom_edms\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;

/**
 * Provides an interface for defining Operation entities.
 *
 * @ingroup freedom_edms
 */
interface EdmsDentryOperationInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Operation name.
   *
   * @return string
   *   Name of the Operation.
   */
  public function getName();

  /**
   * Sets the Operation name.
   *
   * @param string $name
   *   The Operation name.
   *
   * @return \Drupal\freedom_edms\Entity\EdmsDentryOperationInterface
   *   The called Operation entity.
   */
  public function setName($name);

  /**
   * Gets the Operation creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Operation.
   */
  public function getCreatedTime();

  /**
   * Sets the Operation creation timestamp.
   *
   * @param int $timestamp
   *   The Operation creation timestamp.
   *
   * @return \Drupal\freedom_edms\Entity\EdmsDentryOperationInterface
   *   The called Operation entity.
   */
  public function setCreatedTime($timestamp);

}
