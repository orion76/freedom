<?php

namespace Drupal\dentry_test\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class PointTestForm.
 */
class PointTestForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $point_test = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $point_test->label(),
      '#description' => $this->t("Label for the Point test."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $point_test->id(),
      '#machine_name' => [
        'exists' => '\Drupal\dentry_test\Entity\PointTest::load',
      ],
      '#disabled' => !$point_test->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $point_test = $this->entity;
    $status = $point_test->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Point test.', [
          '%label' => $point_test->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Point test.', [
          '%label' => $point_test->label(),
        ]));
    }
    $form_state->setRedirectUrl($point_test->toUrl('collection'));
  }

}
