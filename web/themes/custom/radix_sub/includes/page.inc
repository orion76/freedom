<?php
/**
 * Implements template_preprocess_html().
 */
function radix_sub_preprocess_page(&$variables) {

  $variables['attributes']['class'][] = 'page';
  if ($variables['is_front']) {
    $variables['attributes']['class'][] = 'page--front';
  } else {
    $path = Drupal::service('path.current')
      ->getPath();
    $variables['attributes']['class'][] = 'page-' . str_replace('/', '-', $path);

    if (_radix_sub_get_is_form_page($path)) {
      $variables['attributes']['class'][] = 'page--form';
    }
  }
  $page = $variables['page'];
  $variables['attributes']['class'][] = 'page-content-columns-' . _radix_sub_get_content_column_count($page);
  $n = 0;
}

function _radix_sub_get_content_column_count($page) {
  $columns_info = [
    'sidebar_left' => 1,
    'content' => 1,
    'sidebar_right' => 1,
  ];

  $columns = array_filter(array_intersect_key($page, $columns_info));

  return count($columns);
}

function _radix_sub_get_is_form_page($path) {
  static $pages;
  if (empty($pages)) {
    $pages = _radix_sub_get_form_pages();
  }
  return isset($pages[$path]) && $pages[$path] === TRUE;
}

function _radix_sub_get_form_pages() {
  return [
    '/user/register' => TRUE,
    '/user/login' => TRUE,
    '/user/password' => TRUE,
  ];
}
