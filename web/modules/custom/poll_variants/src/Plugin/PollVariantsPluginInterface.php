<?php

namespace Drupal\poll_variants\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines an interface for Poll variants plugin plugins.
 */
interface PollVariantsPluginInterface extends PluginInspectionInterface {


    public function getVariants($settings = NULL);

    /**
     * @param $values
     * @param $ajax
     *   $ajax['field'] - #ajax settings for update field elements
     * @param $form
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     *
     * @return array
     */
    public function getSettingsForm($values, $ajax, $form, FormStateInterface $form_state): array;

    public function hasSettings(): bool;

    public function validateSettings($form, FormStateInterface $form_state);

    public function needValidate(): bool;

    /**
     * @return array|null
     */
    public function getSettingsFields();
}
