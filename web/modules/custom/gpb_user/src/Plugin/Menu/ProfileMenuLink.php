<?php

namespace Drupal\gpb_user\Plugin\Menu;

use Drupal\Core\Menu\MenuLinkDefault;
use Drupal\user\Entity\User;

class ProfileMenuLink extends MenuLinkDefault {

    /**
     * {@inheritdoc}
     */
    public function getUrlObject($title_attribute = TRUE) {
        $this->pluginDefinition['route_parameters']['user'] = $this->getCurrentUserId();
        return parent::getUrlObject($title_attribute);
    }

    private function getCurrentUserId() {
        $id = NULL;
        $route_math = \Drupal::routeMatch();
        $user = $route_math->getParameter('user');
        if (!$user instanceof User) {
            $user = \Drupal::currentUser();
        }
        $id = $user->id();
        return $id;
    }

}
