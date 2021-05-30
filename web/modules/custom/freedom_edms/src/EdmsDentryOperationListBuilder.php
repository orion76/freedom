<?php

namespace Drupal\freedom_edms;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Operation entities.
 *
 * @ingroup freedom_edms
 */
class EdmsDentryOperationListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Operation ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\freedom_edms\Entity\EdmsDentryOperation $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.edms_dentry_operation.edit_form',
      ['edms_dentry_operation' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
