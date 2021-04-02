<?php

namespace Drupal\site_events\Services;

use Drupal\Core\Entity\EntityInterface;

interface EntityEventServiceInterface {

    const ACTION_CREATE = 'create';

    const ACTION_UPDATE = 'update';

    const ACTION_DELETE = 'delete';

    public function dispatch( $event, EntityInterface $entity);
}
