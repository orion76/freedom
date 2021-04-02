<?php

namespace Drupal\site_events\Plugin;

use Drupal\Component\Plugin\PluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Base class for Site subscriber plugins.
 */
abstract class SiteSubscriberPluginBase extends PluginBase implements SiteSubscriberPluginInterface {

    private $data;

    public function __construct(array $configuration, $plugin_id, $plugin_definition) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
    }

    public function getLabel() {
        return $this->pluginDefinition['label'];
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static($configuration, $plugin_id, $plugin_definition);
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }
}
