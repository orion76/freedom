<?php

namespace Drupal\site_events\Entity\Handlers;

use Drupal\Core\Config\Entity\ConfigEntityStorage;

/**
 *
 * This extends the default content entity storage class,
 * adding required special handling for poll entities.
 */
class SiteEventSubscriberStorage extends ConfigEntityStorage implements SiteEventSubscriberStorageInterface {

    public function loadSubscribers($event_id) {
        return $this->loadByProperties(['event_id' => $event_id]);
    }
}
