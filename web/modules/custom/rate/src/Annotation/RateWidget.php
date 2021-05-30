<?php

namespace Drupal\rate\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Rate widget item annotation object.
 *
 * @see \Drupal\rate\Plugin\RateWidgetManager
 * @see plugin_api
 *
 * @Annotation
 */
class RateWidget extends Plugin {


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

}
