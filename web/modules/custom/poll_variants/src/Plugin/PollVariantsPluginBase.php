<?php

namespace Drupal\poll_variants\Plugin;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Console\Command\Shared\TranslationTrait;
use Drupal\Core\Form\FormStateInterface;

/**
 * Base class for Poll variants plugin plugins.
 */
abstract class PollVariantsPluginBase extends PluginBase implements PollVariantsPluginInterface {

    use TranslationTrait;
    public function hasSettings(): bool {
        return isset($this->pluginDefinition['has_settings']) && $this->pluginDefinition['has_settings'];
    }


    public function needValidate(): bool {
        return isset($this->pluginDefinition['need_validation']) && $this->pluginDefinition['need_validation'];
    }

    public function getSettingsFields() {
        return isset($this->pluginDefinition['setting_fields'])? $this->pluginDefinition['setting_fields']:NULL;
    }
    public function validateSettings($form, FormStateInterface $form_state) {
        // TODO: Implement validateSettings() method.
    }
    public function getSettingsForm($values, $ajax, $form, FormStateInterface $form_state): array {
        return [];
    }
}
