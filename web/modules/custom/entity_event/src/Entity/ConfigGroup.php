<?php

namespace Drupal\entity_event\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Config group entity.
 *
 * @ConfigEntityType(
 *   id = "config_group",
 *   label = @Translation("Config group"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\entity_event\ConfigGroupListBuilder",
 *     "form" = {
 *       "add" = "Drupal\entity_event\Form\ConfigGroupForm",
 *       "edit" = "Drupal\entity_event\Form\ConfigGroupForm",
 *       "delete" = "Drupal\entity_event\Form\ConfigGroupDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\entity_event\ConfigGroupHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "config_group",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/entity-event/config_group/{config_group}",
 *     "add-form" = "/admin/structure/entity-event/config_group/add",
 *     "edit-form" = "/admin/structure/entity-event/config_group/{config_group}/edit",
 *     "delete-form" = "/admin/structure/entity-event/config_group/{config_group}/delete",
 *     "collection" = "/admin/structure/entity-event/config_group"
 *   }
 * )
 */
class ConfigGroup extends ConfigEntityBase implements ConfigGroupInterface {

  /**
   * The Config group ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Config group label.
   *
   * @var string
   */
  protected $label;

}
