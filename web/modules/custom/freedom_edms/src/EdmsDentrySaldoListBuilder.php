<?php

namespace Drupal\freedom_edms;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Saldo entities.
 *
 * @ingroup freedom_edms
 */
class EdmsDentrySaldoListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Saldo ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\freedom_edms\Entity\EdmsDentrySaldo $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.edms_dentry_saldo.edit_form',
      ['edms_dentry_saldo' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
