<?php

namespace Drupal\freedom_edms\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class AdminEdmsController.
 */
class AdminEdmsController extends ControllerBase {

  /**
   * Overview.
   *
   * @return string
   *   Return Hello string.
   */
  public function overview() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: overview')
    ];
  }

}
