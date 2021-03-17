<?php

namespace Drupal\entity_event\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ConfigGroupForm.
 */
class ConfigGroupForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $config_group = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $config_group->label(),
      '#description' => $this->t("Label for the Config group."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $config_group->id(),
      '#machine_name' => [
        'exists' => '\Drupal\entity_event\Entity\ConfigGroup::load',
      ],
      '#disabled' => !$config_group->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $config_group = $this->entity;
    $status = $config_group->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Config group.', [
          '%label' => $config_group->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Config group.', [
          '%label' => $config_group->label(),
        ]));
    }
    $form_state->setRedirectUrl($config_group->toUrl('collection'));
  }

}
