<?php

namespace Drupal\dentry_test\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Point test entity.
 *
 * @ConfigEntityType(
 *   id = "point_test",
 *   label = @Translation("Point test"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\dentry_test\PointTestListBuilder",
 *     "form" = {
 *       "add" = "Drupal\dentry_test\Form\PointTestForm",
 *       "edit" = "Drupal\dentry_test\Form\PointTestForm",
 *       "delete" = "Drupal\dentry_test\Form\PointTestDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\dentry_test\PointTestHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "point_test",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/point_test/{point_test}",
 *     "add-form" = "/admin/structure/point_test/add",
 *     "edit-form" = "/admin/structure/point_test/{point_test}/edit",
 *     "delete-form" = "/admin/structure/point_test/{point_test}/delete",
 *     "collection" = "/admin/structure/point_test"
 *   },
 *   config_export = {
        "id",
 *      "label",
 *      "uuid",
 *      "code",
 *      "parent_id",
 *      "account_type",
 *      "account_item",
 *      "subconto",
 *   }
 * )
 */
class PointTest extends ConfigEntityBase implements PointTestInterface {

  /**
   * The Point test ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Point test label.
   *
   * @var string
   */
  protected $label;

}
