<?php

namespace Drupal\poll_variants\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Poll variant entity config entity.
 *
 * @ConfigEntityType(
 *   id = "poll_variant_entity_config",
 *   label = @Translation("Poll variant entity config"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\poll_variants\PollVariantEntityConfigListBuilder",
 *     "form" = {
 *       "add" = "Drupal\poll_variants\Form\PollVariantEntityConfigForm",
 *       "edit" = "Drupal\poll_variants\Form\PollVariantEntityConfigForm",
 *       "delete" = "Drupal\poll_variants\Form\PollVariantEntityConfigDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\poll_variants\PollVariantEntityConfigHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "poll_variant_entity_config",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
 *     "id",
 *     "type",
 *     "callback",
 *     "data",
 *     "variants"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/poll_variant_entity_config/{poll_variant_entity_config}",
 *     "add-form" = "/admin/structure/poll_variant_entity_config/add",
 *     "edit-form" = "/admin/structure/poll_variant_entity_config/{poll_variant_entity_config}/edit",
 *     "delete-form" = "/admin/structure/poll_variant_entity_config/{poll_variant_entity_config}/delete",
 *     "collection" = "/admin/structure/poll_variant_entity_config"
 *   }
 * )
 */
class PollVariantEntityConfig extends ConfigEntityBase implements PollVariantEntityConfigInterface {

  /**
   * The Poll variant entity config ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Poll variant entity config label.
   *
   * @var string
   */
  protected $label;

}
