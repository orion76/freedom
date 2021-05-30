<?php

namespace Drupal\freedom_edms;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Saldo entity.
 *
 * @see \Drupal\freedom_edms\Entity\EdmsDentrySaldo.
 */
class EdmsDentrySaldoAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\freedom_edms\Entity\EdmsDentrySaldoInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished saldo entities');
        }


        return AccessResult::allowedIfHasPermission($account, 'view published saldo entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit saldo entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete saldo entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add saldo entities');
  }


}
