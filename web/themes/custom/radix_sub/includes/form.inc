<?php
/**
 * @file
 * Theme and preprocess functions for forms.
 */
function radix_sub_preprocess_form_element(&$variables) {
  $element = &$variables['element'];
  $n = 0;
}

function radix_sub_preprocess_input__submit(&$variables) {
  $parents = array_slice($variables['element']['#parents'], -1, 1);
  $action = reset($parents);

  switch ($action) {
    case 'preview':
      $variables['button_type'] = 'default';
      break;
    case 'submit':
      $variables['button_type'] = 'primary';
      break;
    default:
      $variables['button_type'] = 'primary';
  }
}

