<?php

namespace Drupal\freedom_views\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\views\Views;
use function array_filter;
use function in_array;
use function intdiv;

/**
 * @ingroup views_field_handlers
 *
 * @ViewsField("gpb_time_left")
 */
class GpbTimeLeft extends FieldPluginBase {


    public function __construct(array $configuration, $plugin_id, $plugin_definition) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
    }

    /**
     * {@inheritdoc}
     */
    public function query() {
        $this->ensureMyTable();
        $range_field = $this->options['range_field'];
        $column = $range_field;
        switch ($this->options['to_date']) {
            case 'start':
                $column .= '_value';
                break;
            case 'end':
                $column .= '_end_value';
                break;
        }
        $table = $this->table;
        $field_table = $table . '__' . $range_field;


        $configuration = [
            'table' => $field_table,
            'field' => 'entity_id',
            'left_table' => $table,
            'left_field' => 'nid',
            'type' => 'INNER',
        ];

        $join = Views::pluginManager('join')->createInstance('standard', $configuration);
        $this->query->addRelationship($field_table, $join, $table);

        $alias = $field_table . "." . $column;

        $expression = "TIMESTAMPDIFF(MINUTE,NOW(),{$alias})";
        $this->field_alias = $this->query->addField(NULL, $expression, 'time_left_field');
    }

    /**
     * {@inheritdoc}
     */
    protected function defineOptions() {
        $options = parent::defineOptions();
        $options['range_field'] = ['default' => NULL];
        $options['to_date'] = ['default' => NULL];

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function buildOptionsForm(&$form, FormStateInterface $form_state) {

        $form['range_field'] = [
            '#type' => 'select',
            '#title' => $this->t('Date range field'),
            '#required' => TRUE,
            '#options' => $this->getFieldsListOptions(),
            '#default_value' => $this->options['range_field'],
        ];
        $form['to_date'] = [
            '#type' => 'select',
            '#title' => $this->t('To date'),
            '#required' => TRUE,
            '#options' => $this->getColumnAliasListOptions(),
            '#default_value' => $this->options['to_date'],
        ];

        parent::buildOptionsForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function render(ResultRow $values) {

        $value = $this->getValue($values);


        if ($value >= 0) {
            $label = $this->t('Time left');
        } else {
            $label = $this->t('Time passed');
            $value *= -1;
        }
        $label .= ":";
        $result = [$label];
        $title_map = [
            'day' => $this->t('days'),
            'hour' => $this->t('hours'),
            'minute' => $this->t('minutes'),
        ];
        $left = $this->convertMinuteToDay($value);


        foreach ($left as $key => $value) {
            if ($key === 'day' && (int) $value === 0) {
                continue;
            }
            $label = $title_map[$key];
            $result[] = "{$value} {$label}";
        }

        return [
            '#markup' => implode(' ', $result),
        ];
    }

    private function convertMinuteToDay($minute) {
        $hours = intdiv($minute, 60);
        $minute_left = $minute % 60;
        $hours_left = $hours % 24;
        $days_left = intdiv($hours, 24);

        return [
            'day' => $days_left,
            'hour' => $hours_left,
            'minute' => $minute_left,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldsListOptions() {
        $field_map = \Drupal::service('entity_field.manager')->getFieldMap();

        $date_range_fields = array_filter($field_map['node'], function ($item) {
            return $item['type'] === "daterange";
        });

        $options = [];
        foreach ($date_range_fields as $field_name => $field_info) {

            $options[$field_name] = $field_name;

        }
        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function getColumnAliasListOptions() {
        $options = [
            'start' => $this->t('Start'),
            'end' => $this->t('End'),
        ];
        return $options;
    }
}
