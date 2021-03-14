<?php

namespace Drupal\entity_event\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Entity event item annotation object.
 *
 * @see \Drupal\entity_event\Plugin\EntityEventManager
 * @see plugin_api
 *
 * @Annotation
 */
class EntityEvent extends Plugin {


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
