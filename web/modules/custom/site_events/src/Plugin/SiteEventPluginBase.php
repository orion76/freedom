<?php

namespace Drupal\site_events\Plugin;

use Drupal\Component\Plugin\PluginBase;
use function ucfirst;

/**
 * Base class for Event plugin plugins.
 */
abstract class SiteEventPluginBase extends PluginBase implements SiteEventPluginInterface {

    private $data;

    public function getLabel() {
        return $this->pluginDefinition['label'];
    }

    public function setData($data) {
        $this->data = $data;
    }


    public function getData() {
        return $this->data;
    }

}
