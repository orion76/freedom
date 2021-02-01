<?php

namespace Drupal\freedom_fields\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\datetime\Plugin\Field\FieldType\DateTimeItem;
use Drupal\datetime\Plugin\Field\FieldType\DateTimeItemInterface;
use Drupal\datetime_range\Plugin\Field\FieldFormatter\DateRangePlainFormatter;
use function system_time_zones;
use const REQUEST_TIME;

/**
 * Plugin implementation of the 'date_range_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "date_range_field_formatter",
 *   label = @Translation("Date range field formatter"),
 *   field_types = {
 *     "daterange"
 *   }
 * )
 */
class DateRangeFieldFormatter extends DateRangePlainFormatter {

    /**
     * {@inheritdoc}
     */
    public static function defaultSettings() {
        return [
                'date_format' => DateTimeItemInterface::DATETIME_STORAGE_FORMAT,
                'prefix_from' => '',
                'prefix_to' => '',
                'two_string' => FALSE,
            ] + parent::defaultSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function settingsForm(array $form, FormStateInterface $form_state) {
        $elements = parent::settingsForm($form, $form_state);

        $elements['date_format'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Date/time format'),
            '#description' => $this->t('See <a href="http://php.net/manual/function.date.php" target="_blank">the documentation for PHP date formats</a>.'),
            '#default_value' => $this->getSetting('date_format'),
        ];


        $elements['two_string'] = [
            '#type' => 'checkbox',
            '#title' => $this->t('Two string'),
            '#description' => '',
            '#default_value' => $this->getSetting('two_string') ?: FALSE,
            '#weight' => 10,
        ];

        $elements['separator']['#weight'] = 11;
        $elements['separator']['#states'] = [
            'visible' => [
                ':input[name="options[settings][two_string]"]' => ['checked' => FALSE],
            ],
        ];
        $elements['prefix_from'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Prefix from'),
            '#description' => '',
            '#default_value' => $this->getSetting('prefix_from') ?: '',
            '#weight' => 20,
        ];
        $elements['prefix_to'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Prefix to'),
            '#description' => '',
            '#default_value' => $this->getSetting('prefix_to') ?: '',
            '#weight' => 21,
        ];


        return $elements;
    }

    /**
     * {@inheritdoc}
     */
    protected function formatDate($date) {
        $format_str = $this->getSetting('date_format');
        $format = $format_str ? $format_str : DateTimeItemInterface::DATETIME_STORAGE_FORMAT;
        $timezone = $this->getSetting('timezone_override') ?: $date->getTimezone()->getName();
        return $this->dateFormatter->format($date->getTimestamp(), 'custom', $format, $timezone != '' ? $timezone : NULL);
    }

    /**
     * {@inheritdoc}
     */
    public function settingsSummary() {
        return parent::settingsSummary();
    }

    /**
     * {@inheritdoc}
     */
    public function viewElements(FieldItemListInterface $items, $langcode) {
        // @todo Evaluate removing this method in
        // https://www.drupal.org/node/2793143 to determine if the behavior and
        // markup in the base class implementation can be used instead.
        $elements = [];
        if ($this->getSetting('two_string')) {
            $separator = ['#markup' => '</br> '];
        } else {
            $separator = ['#plain_text' => ' ' . $this->getSetting('separator') . ' '];
        }


        foreach ($items as $delta => $item) {
            if (!empty($item->start_date) && !empty($item->end_date)) {
                /** @var \Drupal\Core\Datetime\DrupalDateTime $start_date */
                $start_date = $item->start_date;
                /** @var \Drupal\Core\Datetime\DrupalDateTime $end_date */
                $end_date = $item->end_date;

                if ($start_date->getTimestamp() !== $end_date->getTimestamp()) {
                    $elements[$delta] = [
                        'start_date' => $this->buildElementDate($start_date,$this->getSetting('prefix_from')),
                        'separator' => $separator,
                        'end_date' => $this->buildElementDate($end_date,$this->getSetting('prefix_to')),
                    ];
                } else {
                    $elements[$delta] = $this->buildElementDate($start_date,);
                }
            }
        }

        return $elements;
    }

    /**
     * Creates a render array from a date object.
     *
     * @param \Drupal\Core\Datetime\DrupalDateTime $date
     *   A date object.
     *
     * @return array
     *   A render array.
     */
    protected function buildElementDate(DrupalDateTime $date, $label) {
        $this->setTimeZone($date);
        $format_date = $this->formatDate($date);
        $build = [

            '#markup' => "<label>{$label}:</label><span> {$format_date}</span>",
            '#cache' => [
                'contexts' => [
                    'timezone',
                ],
            ],
        ];

        return $build;
    }

    protected function buildDateElement(DrupalDateTime $date, $type, $prefix) {
        $this->setTimeZone($date);

        $build = [
            '#type' => 'container',
            'prefix' => $prefix,
            'date' => $this->formatDate($date),
            '#cache' => [
                'contexts' => [
                    'timezone',
                ],
            ],
        ];

        return $build;
    }

    /**
     * Generate the output appropriate for one field item.
     *
     * @param \Drupal\Core\Field\FieldItemInterface $item
     *   One field item.
     *
     * @return string
     *   The textual output generated.
     */
    protected function viewValue(FieldItemInterface $item) {
        // The text value has no text format assigned to it, so the user input
        // should equal the output, including newlines.
        return nl2br(Html::escape($item->value));
    }

}
