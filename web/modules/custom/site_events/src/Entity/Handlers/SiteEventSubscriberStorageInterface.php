<?php

namespace Drupal\site_events\Entity\Handlers;

use Drupal\Core\Config\Entity\ConfigEntityStorageInterface;


interface SiteEventSubscriberStorageInterface extends ConfigEntityStorageInterface {

    public function loadSubscribers($event_id);

}
