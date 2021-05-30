<?php

namespace Drupal\freedom_edms;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Entry entity.
 *
 * @see \Drupal\freedom_edms\Entity\EdmsDentry.
 */
class EdmsDentryAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\freedom_edms\Entity\EdmsDentryInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished entry entities');
        }


        return AccessResult::allowedIfHasPermission($account, 'view published entry entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit entry entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete entry entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add entry entities');
  }


}
