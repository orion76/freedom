<?php

namespace Drupal\dentry\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Document entry item annotation object.
 *
 * @see \Drupal\dentry\Plugin\DocumentEntryManager
 * @see plugin_api
 *
 * @Annotation
 */
class DocumentEntry extends Plugin {


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


  public $entity_type;

  public $bundle;

}
