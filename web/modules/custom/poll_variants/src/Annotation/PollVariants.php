<?php

namespace Drupal\poll_variants\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Poll variants plugin item annotation object.
 *
 * @see \Drupal\poll_variants\Plugin\PollVariantsPluginManager
 * @see plugin_api
 *
 * @Annotation
 */
class PollVariants extends Plugin {


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

    public $has_settings;

    public $need_validation;

    public $setting_fields;
}
