<?php

/**
 * @file
 * Contains edms_dentry.page.inc.
 *
 * Page callback for Entry entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Entry templates.
 *
 * Default template: edms_dentry.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_edms_dentry(array &$variables) {
  // Fetch EdmsDentry Entity Object.
  $edms_dentry = $variables['elements']['#edms_dentry'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
