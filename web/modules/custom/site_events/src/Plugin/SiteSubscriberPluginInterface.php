<?php

namespace Drupal\site_events\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

/**
 * Defines an interface for Site subscriber plugins.
 */
interface SiteSubscriberPluginInterface extends PluginInspectionInterface ,ContainerFactoryPluginInterface{


    public function execute( $data);
    public function getLabel();

}
