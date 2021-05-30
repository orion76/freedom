<?php

namespace Drupal\freedom_edms\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Edms point entity.
 *
 * @ConfigEntityType(
 *   id = "edms_point",
 *   label = @Translation("Edms point"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\freedom_edms\EdmsPointListBuilder",
 *     "form" = {
 *       "add" = "Drupal\freedom_edms\Form\EdmsPointForm",
 *       "edit" = "Drupal\freedom_edms\Form\EdmsPointForm",
 *       "delete" = "Drupal\freedom_edms\Form\EdmsPointDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\freedom_edms\EdmsPointHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "edms_point",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/edms/edms_point/{edms_point}",
 *     "add-form" = "/admin/structure/edms/edms_point/add",
 *     "edit-form" = "/admin/structure/edms/edms_point/{edms_point}/edit",
 *     "delete-form" = "/admin/structure/edms/edms_point/{edms_point}/delete",
 *     "collection" = "/admin/structure/edms/edms_point"
 *   }
 * )
 */
class EdmsPoint extends ConfigEntityBase implements EdmsPointInterface {

  /**
   * The Edms point ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Edms point label.
   *
   * @var string
   */
  protected $label;

}
