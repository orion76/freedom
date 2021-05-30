<?php

namespace Drupal\freedom_edms;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Entry entities.
 *
 * @ingroup freedom_edms
 */
class EdmsDentryListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Entry ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\freedom_edms\Entity\EdmsDentry $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.edms_dentry.edit_form',
      ['edms_dentry' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
