<?php

namespace Drupal\site_events\Plugin;


use Drupal\Component\Plugin\PluginManagerInterface;

/**
 * Provides the Site subscriber plugin manager.
 */
interface SiteEventPluginManagerInterface extends PluginManagerInterface {

    public function getOptionsList();

    public function getEvent($source, $event);
}
