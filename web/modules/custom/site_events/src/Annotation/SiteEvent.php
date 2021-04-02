<?php

namespace Drupal\site_events\Annotation;

use Drupal\Component\Annotation\Plugin;
use function implode;

/**
 * Defines a Event plugin item annotation object.
 *
 * @see \Drupal\site_events\Plugin\SiteEventPluginManager
 * @see plugin_api
 *
 * @Annotation
 */
class SiteEvent extends Plugin {


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

    public $source;

    public $event;

}
