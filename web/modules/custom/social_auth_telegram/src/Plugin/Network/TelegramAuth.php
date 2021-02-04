<?php

namespace Drupal\social_auth_telegram\Plugin\Network;

use Drupal\Core\Url;
use Drupal\social_api\SocialApiException;
use Drupal\social_auth\Plugin\Network\NetworkBase;
use Drupal\social_auth_telegram\Settings\TelegramAuthSettings;


/**
 * Defines a Network Plugin for Social Auth Telegram.
 *
 * @package Drupal\social_auth_telegram\Plugin\Network
 *
 * @Network(
 *   id = "social_auth_telegram",
 *   social_network = "Telegram",
 *   type = "social_auth",
 *   handlers = {
 *     "settings": {
 *       "class": "\Drupal\social_auth_telegram\Settings\TelegramAuthSettings",
 *       "config_id": "social_auth_telegram.settings"
 *     }
 *   }
 * )
 */
class TelegramAuth extends NetworkBase implements TelegramAuthInterface {

  /**
   * Sets the underlying SDK library.
   *
   * @return \League\OAuth2\Client\Provider\Telegram|false
   *   The initialized 3rd party library instance.
   *   False if library could not be initialized.
   *
   * @throws \Drupal\social_api\SocialApiException
   *   If the SDK library does not exist.
   */
  protected function initSdk() {

    $class_name = '\League\OAuth2\Client\Provider\Telegram';
    if (!class_exists($class_name)) {
      throw new SocialApiException(sprintf('The Telegram library for PHP League OAuth2 not found. Class: %s.', $class_name));
    }

    /** @var \Drupal\social_auth_telegram\Settings\TelegramAuthSettings $settings */
    $settings = $this->settings;

    if ($this->validateConfig($settings)) {
      // All these settings are mandatory.
      $league_settings = [
        'clientId' => $settings->getClientId(),
        'clientSecret' => $settings->getClientSecret(),
        'redirectUri' => Url::fromRoute('social_auth_telegram.callback')->setAbsolute()->toString(),
      ];

      // Proxy configuration data for outward proxy.
      $proxyUrl = $this->siteSettings->get('http_client_config')['proxy']['http'];
      if ($proxyUrl) {
        $league_settings['proxy'] = $proxyUrl;
      }

      return FALSE;
    }

    return FALSE;
  }

  /**
   * Checks that module is configured.
   *
   * @param \Drupal\social_auth_telegram\Settings\TelegramAuthSettings $settings
   *   The Telegram auth settings.
   *
   * @return bool
   *   True if module is configured.
   *   False otherwise.
   */
  protected function validateConfig(TelegramAuthSettings $settings) {
    $client_id = $settings->getClientId();
    $client_secret = $settings->getClientSecret();
    if (!$client_id || !$client_secret) {
      $this->loggerFactory
        ->get('social_auth_telegram')
        ->error('Define Client ID and Client Secret on module settings.');

      return FALSE;
    }

    return TRUE;
  }

}
