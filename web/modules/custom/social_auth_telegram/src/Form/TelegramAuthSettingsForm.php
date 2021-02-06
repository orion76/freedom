<?php

namespace Drupal\social_auth_telegram\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\social_auth\Form\SocialAuthSettingsForm;

/**
 * Settings form for Social Auth Telegram.
 */
class TelegramAuthSettingsForm extends SocialAuthSettingsForm {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'social_auth_telegram_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return array_merge(
      parent::getEditableConfigNames(),
      ['social_auth_telegram.settings']
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('social_auth_telegram.settings');

    $form['telegram_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Telegram Client settings'),
      '#open' => TRUE,
    ];
      $form['telegram_settings']['token'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Token'),
          '#default_value' => $config->get('token'),
          '#description' => $this->t('Bot token.'),
          '#required' => TRUE,
      ];
      $form['telegram_settings']['widget_code'] = [
          '#type' => 'textarea',
          '#required' => TRUE,
          '#title' => $this->t('Widget code'),
          '#cols' => '80',
          '#rows' => '4',
          '#default_value' => $config->get('widget_code'),
          '#description' => $this->t('Copy the Telegram widget code here.'),
      ];
      $form['telegram_settings']['email_domain'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Email domain'),
          '#default_value' => $config->get('email_domain'),
          '#description' => $this->t('Email domain for generating bogus email addresses. Email does not provide Telegram.'),
          '#required' => TRUE,
      ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

      $this->config('social_auth_telegram.settings')
          ->set('token', $values['token'])
          ->set('widget_code', $values['widget_code'])
          ->set('email_domain', $values['email_domain'])
          ->save();
    
    parent::submitForm($form, $form_state);
  }

}
