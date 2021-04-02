<?php

namespace Drupal\site_events\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Event subscriber group entity.
 *
 * @ConfigEntityType(
 *   id = "site_event_subscriber_group",
 *   label = @Translation("Event subscriber group"),
 *   handlers = {
 *     "storage" = "Drupal\site_events\Entity\Handlers\SiteEventSubscriberGroupStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\site_events\Entity\Handlers\SiteEventSubscriberGroupListBuilder",
 *     "form" = {
 *       "add" = "Drupal\site_events\Entity\Form\SiteEventSubscriberGroupForm",
 *       "edit" = "Drupal\site_events\Entity\Form\SiteEventSubscriberGroupForm",
 *       "delete" = "Drupal\site_events\Entity\Form\SiteEventSubscriberGroupDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\site_events\Entity\Handlers\SiteEventSubscriberGroupHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "site_event_subscriber_group",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/site_events/site_event_subscriber_group/{site_event_subscriber_group}",
 *     "add-form" = "/admin/structure/site_events/site_event_subscriber_group/add",
 *     "edit-form" = "/admin/structure/site_events/site_event_subscriber_group/{site_event_subscriber_group}/edit",
 *     "delete-form" = "/admin/structure/site_events/site_event_subscriber_group/{site_event_subscriber_group}/delete",
 *     "collection" = "/admin/structure/site_events/site_event_subscriber_group"
 *   }
 * )
 */
class SiteEventSubscriberGroup extends ConfigEntityBase implements SiteEventSubscriberGroupInterface {

  /**
   * The Event subscriber group ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Event subscriber group label.
   *
   * @var string
   */
  protected $label;

}
