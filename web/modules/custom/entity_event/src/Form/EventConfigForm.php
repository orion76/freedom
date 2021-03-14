<?php

namespace Drupal\entity_event\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class EventConfigForm.
 */
class EventConfigForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $event_config = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $event_config->label(),
      '#description' => $this->t("Label for the Event config."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $event_config->id(),
      '#machine_name' => [
        'exists' => '\Drupal\entity_event\Entity\EventConfig::load',
      ],
      '#disabled' => !$event_config->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $event_config = $this->entity;
    $status = $event_config->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Event config.', [
          '%label' => $event_config->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Event config.', [
          '%label' => $event_config->label(),
        ]));
    }
    $form_state->setRedirectUrl($event_config->toUrl('collection'));
  }

}
