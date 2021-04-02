<?php

namespace Drupal\site_events\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Event subscriber entities.
 */
interface SiteEventSubscriberInterface extends ConfigEntityInterface {

    public function getGroupId();

    public function getSourceType();

    public function getSourceBundle();

    public function getEventId();

    public function getSubscriberId();
}
