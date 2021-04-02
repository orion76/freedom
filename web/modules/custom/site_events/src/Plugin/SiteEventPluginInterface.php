<?php

namespace Drupal\site_events\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;


/**
 * Defines an interface for Event plugin plugins.
 */
interface SiteEventPluginInterface extends PluginInspectionInterface {

    public function getLabel();

    public function setData($data);

    public function getData();

}
