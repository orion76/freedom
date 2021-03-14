<?php

namespace Drupal\entity_event\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Entity action item annotation object.
 *
 * @see \Drupal\entity_event\Plugin\EntityActionManager
 * @see plugin_api
 *
 * @Annotation
 */
class EntityAction extends Plugin {


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
