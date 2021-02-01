<?php

namespace Drupal\freedom_views\Plugin\views\filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\filter\FilterPluginBase;

/**
 * Filter handler for the newer of last comment / node updated.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("date_range_event_filter")
 */
class DateRangeEvent extends FilterPluginBase {

    public function operators() {
        return [
            'is' => [
                'title' => $this->t('The event is'),
                'method' => 'opStateIs',
                'short' => $this->t('Is'),
                'values' => 1,
            ],
        ];
    }

    /**
     * The form that is show (including the exposed form).
     */
    protected function valueForm(&$form, FormStateInterface $form_state) {
        $form['value'] = [
            '#tree' => TRUE,
            'state' => [
                '#type' => 'select',
                '#title' => $this->t('Event status'),
                '#options' => [
                    'all' => $this->t('All'),
                    'expected' => $this->t('Expected'),
                    'started' => $this->t('Started'),
                    'finished' => $this->t('Finished'),
                ],
                '#default_value' => !empty($this->value['state']) ? $this->value['state'] : 'all',
            ],
        ];
    }

    /**
     * Applying query filter. If you turn on views query debugging you should see
     * these clauses applied. If the filter is optional, and nothing is selected, this
     * code will never be called.
     */
    public function opStateIs() {
        $this->ensureMyTable();
        $field_alias = substr("{$this->tableAlias}.{$this->realField}",0,-6);
        $start_field_name = "{$field_alias}_value";
        $end_field_name = "{$field_alias}_end_value";

        // Prepare sql clauses for each field.
        $date_start = $this->query->getDateFormat($this->query->getDateField($start_field_name, TRUE), 'Y-m-d H:i:s', FALSE);
        $date_end = $this->query->getDateFormat($this->query->getDateField($end_field_name, TRUE), 'Y-m-d H:i:s', FALSE);
        $date_now = $this->query->getDateFormat('FROM_UNIXTIME(***CURRENT_TIME***)', 'Y-m-d H:i:s', FALSE);

        switch ($this->value['state']) {
            case 'expected':
                $this->query->addWhereExpression($this->options['group'], "$date_now < $date_start");
                break;
            case 'started':
                $this->query->addWhereExpression($this->options['group'], "$date_now BETWEEN $date_start AND $date_end");
                break;

            case 'finished':
                $this->query->addWhereExpression($this->options['group'], "$date_now > $date_end");
                break;

        }
    }

    /**
     * Admin summary makes it nice for editors.
     */
    public function adminSummary() {

        if ($this->isAGroup()) {
            return $this->t('grouped');
        }
        if (!empty($this->options['exposed'])) {
            return $this->t('exposed') . ', ' . $this->t('default state') . ': ' . $this->value['state'];
        } else {
            return $this->t('state') . ': ' . $this->value['state'];
        }
    }
}
