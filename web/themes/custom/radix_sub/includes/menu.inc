<?php
/**
 * Implements hook_preprocess_menu().
 */
function radix_sub_preprocess_menu(&$variables, $hook) {
    // No changes for menu toolbar.
    if ($hook !== 'menu__account') {
        return;
    }

    $icons = [
        'user.logout' => '<i class="fas fa-sign-out-alt fa-lg"></i>',
        'user.page' => '<i class="fas fa-user fa-lg"></i>',
    ];
    $items = $variables['items'];
    foreach ($items as $key => $item) {
        if (isset($icons[$key])) {
            $variables['items'][$key]['title'] =['#markup'=> $icons[$key]];
        }

    }
}
