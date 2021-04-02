<?php

namespace Drupal\site_events\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Site subscriber item annotation object.
 *
 * @see \Drupal\site_events\Plugin\SiteSubscriberPluginManager
 * @see plugin_api
 *
 * @Annotation
 */
class SiteSubscriber extends Plugin {


    /**
     * The plugin ID.
     *
     * @var string
     */
    public $id;

    /**
     * The label of the plugin.
     *
     * @var \Drupal\Core\Annotation\Translation
     *
     * @ingroup plugin_translatable
     */
    public $label;

    public $condition;

    public $configaration;
}
