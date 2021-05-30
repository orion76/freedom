<?php

/**
 * @file
 * Contains edms_dentry_operation.page.inc.
 *
 * Page callback for Operation entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Operation templates.
 *
 * Default template: edms_dentry_operation.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_edms_dentry_operation(array &$variables) {
  // Fetch EdmsDentryOperation Entity Object.
  $edms_dentry_operation = $variables['elements']['#edms_dentry_operation'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
