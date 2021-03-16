<?php
/**
 * @file
 * Theme and preprocess functions for views.
 */
function radix_sub_preprocess_views_view(&$variables) {

    /** @var $views \Drupal\views\ViewExecutable */
    $views = $variables['view'];
    $display = $views->getDisplay();
    /** @var $plugin_style \Drupal\views\Plugin\views\style\DefaultStyle */
    $plugin_style = $display->getPlugin('style');
    $plugin_style->displayHandler->getType();
    $definition = $plugin_style->getPluginDefinition();
    $n = 0;
    $row_style = substr($definition['theme'], 11);
    $variables['attributes']['class'][] = "views-row-style--{$row_style}";
}
