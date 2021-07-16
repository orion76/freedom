<?php

namespace Drupal\freedom_group\Plugin\Menu;

use Drupal;
use Drupal\Core\Menu\MenuLinkDefault;

class GroupLink extends MenuLinkDefault {

  public function getUrlObject($title_attribute = TRUE) {
    $this->pluginDefinition['route_parameters']['group'] = $this->getCurrentGroupId();
    return parent::getUrlObject($title_attribute);
  }

  private function getCurrentGroupId() {
    $id = NULL;
    $route_math = Drupal::routeMatch();
    $group = $route_math->getParameter('group');

    if (!empty($group)) {
      $id = $group->id();
    }

    return $id;
  }
}
