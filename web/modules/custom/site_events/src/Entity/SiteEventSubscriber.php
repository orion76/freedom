<?php

namespace Drupal\site_events\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Event subscriber entity.
 *
 * @ConfigEntityType(
 *   id = "site_event_subscriber",
 *   label = @Translation("Event subscriber"),
 *   handlers = {
 *     "storage" = "Drupal\site_events\Entity\Handlers\SiteEventSubscriberStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\site_events\Entity\Handlers\SiteEventSubscriberListBuilder",
 *     "form" = {
 *       "add" = "Drupal\site_events\Entity\Form\SiteEventSubscriberForm",
 *       "edit" = "Drupal\site_events\Entity\Form\SiteEventSubscriberForm",
 *       "delete" = "Drupal\site_events\Entity\Form\SiteEventSubscriberDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\site_events\Entity\Handlers\SiteEventSubscriberHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "site_event_subscriber",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/site_events/site_event_subscriber/{site_event_subscriber}",
 *     "add-form" = "/admin/structure/site_events/site_event_subscriber/add",
 *     "edit-form" = "/admin/structure/site_events/site_event_subscriber/{site_event_subscriber}/edit",
 *     "delete-form" = "/admin/structure/site_events/site_event_subscriber/{site_event_subscriber}/delete",
 *     "collection" = "/admin/structure/site_events/site_event_subscriber"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "group_id",
 *     "source",
 *     "event_id",
 *     "subscriber_id",
 *   },
 *   lookup_keys = {
 *     "group_id",
 *     "event_id",
 *     "source.type",
 *     "source.bundle"
 *   }
 * )
 */
class SiteEventSubscriber extends ConfigEntityBase implements SiteEventSubscriberInterface {

    /**
     * The Event subscriber ID.
     *
     * @var string
     */
    protected $id;

    /**
     * The Event subscriber label.
     *
     * @var string
     */
    protected $label;

    protected $group_id;

    protected $source;

    protected $event_id;

    protected $subscriber_id;

    public function getGroupId() {
        return $this->group_id;
    }

    public function getSourceType() {
        return $this->source['type'];
    }

    public function getSourceBundle() {
        return $this->source['bundle'];
    }

    public function getEventId() {
        return $this->event_id;
    }

    public function getSubscriberId() {
        return $this->subscriber_id;
    }
}
