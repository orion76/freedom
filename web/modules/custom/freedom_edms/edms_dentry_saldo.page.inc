<?php

/**
 * @file
 * Contains edms_dentry_saldo.page.inc.
 *
 * Page callback for Saldo entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Saldo templates.
 *
 * Default template: edms_dentry_saldo.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_edms_dentry_saldo(array &$variables) {
  // Fetch EdmsDentrySaldo Entity Object.
  $edms_dentry_saldo = $variables['elements']['#edms_dentry_saldo'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
