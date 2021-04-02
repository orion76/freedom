<?php

namespace Drupal\site_events\Entity\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SiteEventSubscriberGroupForm.
 */
class SiteEventSubscriberGroupForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $event_subscriber_group = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $event_subscriber_group->label(),
      '#description' => $this->t("Label for the Event subscriber group."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $event_subscriber_group->id(),
      '#machine_name' => [
        'exists' => '\Drupal\site_events\Entity\SiteEventSubscriberGroup::load',
      ],
      '#disabled' => !$event_subscriber_group->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $event_subscriber_group = $this->entity;
    $status = $event_subscriber_group->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Event subscriber group.', [
          '%label' => $event_subscriber_group->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Event subscriber group.', [
          '%label' => $event_subscriber_group->label(),
        ]));
    }
    $form_state->setRedirectUrl($event_subscriber_group->toUrl('collection'));
  }

}
