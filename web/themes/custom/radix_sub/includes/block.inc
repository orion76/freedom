<?php
/**
 * @file
 * Theme and preprocess functions for blocks.
 */
function radix_sub_preprocess_block(&$variables) {
  $n = 0;
  $variables['title_attributes']['class'][] = 'with-icon';
}
