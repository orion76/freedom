<?php

namespace Drupal\freedom_edms\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class EdmsPointForm.
 */
class EdmsPointForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $edms_point = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $edms_point->label(),
      '#description' => $this->t("Label for the Edms point."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $edms_point->id(),
      '#machine_name' => [
        'exists' => '\Drupal\freedom_edms\Entity\EdmsPoint::load',
      ],
      '#disabled' => !$edms_point->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $edms_point = $this->entity;
    $status = $edms_point->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Edms point.', [
          '%label' => $edms_point->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Edms point.', [
          '%label' => $edms_point->label(),
        ]));
    }
    $form_state->setRedirectUrl($edms_point->toUrl('collection'));
  }

}
