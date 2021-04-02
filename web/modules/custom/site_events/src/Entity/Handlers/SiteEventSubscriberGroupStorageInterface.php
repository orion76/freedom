<?php

namespace Drupal\site_events\Entity\Handlers;

use Drupal\Core\Config\Entity\ConfigEntityStorageInterface;


interface SiteEventSubscriberGroupStorageInterface extends ConfigEntityStorageInterface {

    public function createOptionsList();

}
