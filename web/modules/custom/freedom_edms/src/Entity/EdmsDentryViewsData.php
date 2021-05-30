<?php

namespace Drupal\freedom_edms\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Entry entities.
 */
class EdmsDentryViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
