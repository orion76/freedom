<?php
/**
 * Implements template_preprocess_html().
 */
function radix_sub_preprocess_page(&$variables) {

    $variables['attributes']['class'][]='page';
    if ($variables['is_front']) {
        $variables['attributes']['class'][] = 'page--front';
    }
}
