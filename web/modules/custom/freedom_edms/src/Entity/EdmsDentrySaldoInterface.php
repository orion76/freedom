<?php

namespace Drupal\freedom_edms\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;

/**
 * Provides an interface for defining Saldo entities.
 *
 * @ingroup freedom_edms
 */
interface EdmsDentrySaldoInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Saldo name.
   *
   * @return string
   *   Name of the Saldo.
   */
  public function getName();

  /**
   * Sets the Saldo name.
   *
   * @param string $name
   *   The Saldo name.
   *
   * @return \Drupal\freedom_edms\Entity\EdmsDentrySaldoInterface
   *   The called Saldo entity.
   */
  public function setName($name);

  /**
   * Gets the Saldo creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Saldo.
   */
  public function getCreatedTime();

  /**
   * Sets the Saldo creation timestamp.
   *
   * @param int $timestamp
   *   The Saldo creation timestamp.
   *
   * @return \Drupal\freedom_edms\Entity\EdmsDentrySaldoInterface
   *   The called Saldo entity.
   */
  public function setCreatedTime($timestamp);

}
