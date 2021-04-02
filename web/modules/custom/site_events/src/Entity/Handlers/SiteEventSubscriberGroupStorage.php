<?php

namespace Drupal\site_events\Entity\Handlers;

use Drupal\Core\Config\Entity\ConfigEntityStorage;
use Drupal\site_events\Entity\SiteEventSubscriberGroupInterface;

/**
 *
 * This extends the default content entity storage class,
 * adding required special handling for poll entities.
 */
class SiteEventSubscriberGroupStorage extends ConfigEntityStorage implements SiteEventSubscriberGroupStorageInterface {


    public function createOptionsList() {
        $options = [
            '' => $this->t('Not in group'),
        ];
        foreach ($this->loadMultiple() as $entity) {
            /** @var $entity SiteEventSubscriberGroupInterface */
            $options[$entity->id()] = $entity->label();
        }
        return $options;
    }
}
