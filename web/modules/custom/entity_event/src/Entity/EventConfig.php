<?php

namespace Drupal\entity_event\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Event config entity.
 *
 * @ConfigEntityType(
 *   id = "event_config",
 *   label = @Translation("Event config"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\entity_event\EventConfigListBuilder",
 *     "form" = {
 *       "add" = "Drupal\entity_event\Form\EventConfigForm",
 *       "edit" = "Drupal\entity_event\Form\EventConfigForm",
 *       "delete" = "Drupal\entity_event\Form\EventConfigDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\entity_event\EventConfigHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "event_config",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/entity-event/event_config/{event_config}",
 *     "add-form" = "/admin/structure/entity-event/event_config/add",
 *     "edit-form" = "/admin/structure/entity-event/event_config/{event_config}/edit",
 *     "delete-form" = "/admin/structure/entity-event/event_config/{event_config}/delete",
 *     "collection" = "/admin/structure/entity-event/event_config"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "group",
 *     "plugin_event",
 *     "plugin_action",
 *   },
 *   lookup_keys = {
 *     "group"
 *   }
 * )
 */
class EventConfig extends ConfigEntityBase implements EventConfigInterface {

    /**
     * The Event config ID.
     *
     * @var string
     */
    protected $id;

    /**
     * The Event config label.
     *
     * @var string
     */
    protected $label;

    /**
     * The Event config group.
     *
     * @var string
     */
    protected $group;

    /**
     * The Event config group.
     *
     * @var string
     */
    protected $plugin_event;

    protected $plugin_action;
}
