<?php

namespace Drupal\dentry_test;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Operation test entity.
 *
 * @see \Drupal\dentry_test\Entity\OperationTest.
 */
class OperationTestAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\dentry_test\Entity\OperationTestInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished operation test entities');
        }


        return AccessResult::allowedIfHasPermission($account, 'view published operation test entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit operation test entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete operation test entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add operation test entities');
  }


}
