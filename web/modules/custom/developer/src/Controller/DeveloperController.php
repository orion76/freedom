<?php

namespace Drupal\developer\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DeveloperController.
 */
class DeveloperController extends ControllerBase {

  /**
   * Execute.
   *
   * @return string
   *   Return Hello string.
   */
  public function execute() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: execute')
    ];
  }

}
