<?php

namespace Drupal\dentry_test\Entity;

use Drupal\dentry\Dentry\Entry;
use Drupal\dentry\Dentry\EntryInterface;

/**
 * Defines the Entry test entity.
 *
 * @ingroup dentry
 *
 * @ContentEntityType(
 *   id = "entry_test",
 *   label = @Translation("Entry test"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\dentry\EntryTestListBuilder",
 *     "views_data" = "Drupal\dentry\Entity\EntryTestViewsData",
 *
 *     "access" = "Drupal\dentry\EntryTestAccessControlHandler",
 *   },
 *   base_table = "entry_test",
 *   translatable = FALSE,
 *   admin_permission = "administer entry test entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *   },
 *   reference_types = {
 *      "operation" = "operation_test",
 *      "point" = "point_test",
 *   },
 * )
 */
class EntryTest extends Entry implements EntryInterface {


}
