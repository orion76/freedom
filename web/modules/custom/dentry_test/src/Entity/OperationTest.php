<?php

namespace Drupal\dentry_test\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\dentry\Dentry\Operation;
use Drupal\dentry\Dentry\OperationInterface;

/**
 * Defines the Operation test entity.
 *
 * @ingroup dentry_test
 *
 * @ContentEntityType(
 *   id = "operation_test",
 *   label = @Translation("Operation test"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\dentry_test\OperationTestListBuilder",
 *     "views_data" = "Drupal\dentry_test\Entity\OperationTestViewsData",
 *
 *     "access" = "Drupal\dentry_test\OperationTestAccessControlHandler",
 *   },
 *   base_table = "operation_test",
 *   translatable = FALSE,
 *   admin_permission = "administer operation test entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *   },
 * )
 */
class OperationTest extends Operation implements OperationInterface  {


}
