<?php

namespace Drupal\poll_variants\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use function array_diff_assoc;
use function array_filter;
use function array_keys;
use function trim;

/**
 * Class PollVariantEntityConfigForm.
 */
class PollVariantEntityConfigForm extends EntityForm {

    private function isAjax($parents, FormStateInterface $form_state) {
        $is_ajax = FALSE;
        if ($triggering_element = $form_state->getTriggeringElement()) {
            $is_ajax = empty(array_diff_assoc($parents, $triggering_element['#parents']));
        }
        return $is_ajax;
    }

    private function isAjaxDelete(FormStateInterface $form_state) {
        $is_delete = FALSE;
        if ($triggering_element = $form_state->getTriggeringElement()) {
            $button_name = end($triggering_element['#parents']);
            $is_delete = $button_name === 'button_delete';
        }
        return $is_delete;
    }

    /**
     * {@inheritdoc}
     */
    public function form(array $form, FormStateInterface $form_state) {
        $form = parent::form($form, $form_state);
        $values = $form_state->getValues();
        /** @var $entity \Drupal\Core\Config\Entity\ConfigEntityInterface */
        $entity = $this->entity;
        $form['label'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Label'),
            '#maxlength' => 255,
            '#default_value' => $entity->label(),
            '#description' => $this->t("Label for the Poll variant entity config."),
            '#required' => TRUE,
        ];

        $form['id'] = [
            '#type' => 'machine_name',
            '#default_value' => $entity->id(),
            '#machine_name' => [
                'exists' => '\Drupal\poll_variants\Entity\PollVariantEntityConfig::load',
            ],
            '#disabled' => !$entity->isNew(),
        ];

        if ($this->isAjax(['has_variants'], $form_state)) {
            $has_variants = (bool) $values['has_variants'];
        } else {
            $has_variants = (bool) $entity->get('has_variants');
        }
        $id_variants = 'poll-variant-config-variant-values';
        $ajax = [
            'callback' => [$this, 'ajaxCallbackAddVariant'],
            'wrapper' => $id_variants,
        ];


        $form['has_variants'] = [
            '#title' => $this->t('Has variants'),
            '#type' => 'checkbox',
            '#default_value' => $has_variants,
            '#ajax' => $ajax,
        ];


        if ($has_variants) {
            $form['variants'] = [
                '#type' => 'details',
                '#title' => 'Values',
                '#attributes' => ['id' => $id_variants],
                '#open' => TRUE,
                '#tree' => TRUE,
            ];
            $form['variants']+=$this->buildVariants($form_state,$ajax);

            $form['variants']['button_add'] = [
                '#type' => 'button',
                '#name' => 'variants[button_add]',
                '#value' => $this->t('Add variant'),
                '#ajax' => $ajax,
            ];
        } else {
            $form['variants'] = [
                '#id' => $id_variants,
                '#type' => 'container',
                '#tree' => TRUE,
            ];
        }

        return $form;
    }

    private function buildVariants(FormStateInterface $form_state, $ajax) {

        if ($this->isAjax([], $form_state)) {
            $variants_values = $form_state->getValue('variants',[]);
        } else {
            $variants_values = $this->entity->get('variants');
        }
        $variants_values = array_filter($variants_values, function ($item) {
            return !$item instanceof TranslatableMarkup;
        });

        $variants_values = array_filter($variants_values, function ($key) use ($form_state) {
            return !$this->isAjax(['variants', $key, 'button_delete'], $form_state);
        }, ARRAY_FILTER_USE_KEY);

        $variants=[];
        
        if (!empty($variants_values)) {
            foreach ($variants_values as $key => $value) {
                $variants[$key] = $this->createVariantElement($value, $ajax);
            }
        }
        if ($this->isAjax(['variants', 'button_add'], $form_state)) {
            $new_value = ['id' => NULL, 'label' => NULL];
            $variants[NULL] = $this->createVariantElement($new_value, $ajax);
        }
        return $variants;
    }


    /**
     * AJAX callback.
     */
    public function ajaxCallbackAddVariant($form, FormStateInterface $form_state) {
        return $form['variants'];
    }

    protected function createVariantElement($variant, $ajax) {
        $element = [
            '#type' => 'fieldset',
            '#tree' => TRUE,
            '#title' => !empty($variant['label']) ? $variant['label'] : $this->t('New variant'),

        ];
        $element['label'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Label'),
            '#maxlength' => 255,
            '#default_value' => $variant['label'],
            '#description' => $this->t("Label for the Poll variant entity config."),
            '#required' => TRUE,
        ];

        $element['id'] = [
            '#type' => 'machine_name',
            '#default_value' => $variant['id'],
            '#machine_name' => [
                'exists' => '\Drupal\poll_variants\Entity\PollVariantEntityConfig::load',
                'replace_pattern' => '[^a-z0-9_.]+',
                'source' => ['label'],
            ],
            '#disabled' => !empty($variant['id']),
        ];

        $key = empty($variant['id']) ? 'new' : $variant['id'];
        $element['button_delete'] = [
            '#type' => 'button',
            '#name' => "variants[{$key}][button_delete]",
            '#value' => $this->t('Delete'),
            '#ajax' => $ajax,
        ];
        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $form, FormStateInterface $form_state) {
        $entity = $this->entity;
        $status = $entity->save();

        switch ($status) {
            case SAVED_NEW:
                $this->messenger()->addMessage($this->t('Created the %label Poll variant entity config.', [
                    '%label' => $entity->label(),
                ]));
                break;

            default:
                $this->messenger()->addMessage($this->t('Saved the %label Poll variant entity config.', [
                    '%label' => $entity->label(),
                ]));
        }
        //        $form_state->setRedirectUrl($poll_variant_entity_config->toUrl('collection'));
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        $this->clearValues($form_state);
        if ($this->isAjaxDelete($form_state)) {
            $form_state->clearErrors();
        }
    }

    protected function clearValues(FormStateInterface $form_state) {
        $values = $form_state->getValues();

        if ((bool) $values['has_variants'] === FALSE) {
            $values['variants'] = [];
        }

        if (isset($values['variants'])) {
            $variants = array_filter($values['variants'], function ($value, $key) {
                if ($key === 'button_add') {
                    return FALSE;
                }
                if (is_null($key)) {
                    return !empty(trim($value['label']));
                }
                return TRUE;
            }, ARRAY_FILTER_USE_BOTH);
            $values['variants'] = $variants;
        }
        $form_state->setValues($values);
    }

}
