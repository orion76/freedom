<?php

/**
 * @file
 * Views hooks.
 */

/**
 * Implements hook_views_data_alter().
 *
 * Alter DB tables defined via hook_views_data().
 */
function freedom_views_views_data_alter(array &$data) {
$n=0;
    $data['users']['fio'] = [
        'title' => t('User FIO'),
        'field' => [
            'title' => t('User FIO'),
            'help' => t('User full name.'),
            'id' => 'user_fio',
            'click sortable' => FALSE,
        ],
    ];
    
    $data['node']['gpb_time_left'] = [
        'title' => t('Time left'),
        'field' => [
            'title' => t('Time left'),
            'help' => t('Time left from current date.'),
            'id' => 'gpb_time_left',
            'click sortable' => FALSE,
        ],
    ];

    $ref_fields = \Drupal::entityTypeManager()->getStorage('field_storage_config')->loadByProperties(
        [
            'entity_type' => 'node',
            'type' => 'daterange',
            'deleted' => FALSE,
            'status' => 1,
        ]
    );

    foreach ($ref_fields as $field_storage) {
        /** @var $field_storage \Drupal\field\Entity\FieldStorageConfig */
        $field_name = $field_storage->getName();
        $field_storage->getColumns();
        $data['node__' . $field_name][$field_name . '_event'] = [
            'title' => t('Date range event filter'),
            'filter' => [
                'title' => t('Date range event filter'),
                'group' => t('Content'),
                'help' => '',
                'field' => 'field_date_range_value',
                'id' => 'date_range_event_filter',
            ],
        ];
    }
}
