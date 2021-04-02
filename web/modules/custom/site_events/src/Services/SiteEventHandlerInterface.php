<?php

namespace Drupal\site_events\Services;

use Drupal\site_events\Plugin\SiteEventPluginInterface;

interface SiteEventHandlerInterface {

    public function handle(SiteEventPLuginInterface $event);
}
