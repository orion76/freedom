<?php

namespace Drupal\gpb_og\Plugin\Field\FieldWidget;

use Drupal;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'gpb_og_reference' widget.
 *
 * @FieldWidget(
 *   id = "gpb_og_reference",
 *   module = "gpb_og",
 *   label = @Translation("Og reference - prepopulate"),
 *   field_types = {
 *     "og_standard_reference",
 *     "og_membership_reference"
 *   }
 * )
 */
class GpbOgReference extends WidgetBase {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  private EntityTypeManagerInterface $entityTypeManager;

  public function __construct($plugin_id,
                              $plugin_definition,
                              FieldDefinitionInterface $field_definition,
                              array $settings,
                              array $third_party_settings,
                              EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings);
    $this->entityTypeManager = $entityTypeManager;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['third_party_settings'],
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
        'size' => 60,
        'placeholder' => '',
      ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    //    $form_state->setProgrammed();
    $entity = $items->getEntity();
    if ($entity->isNew() && $group_id = Drupal::request()->query->get('og_group_id')) {
      $entity_type = $this->fieldDefinition->getTargetEntityTypeId();
      $group = $this->entityTypeManager->getStorage($entity_type)->load($group_id);
    } else {
      $referenced_entities = $items->referencedEntities();
      $group = isset($referenced_entities[$delta]) ? $referenced_entities[$delta] : NULL;
    }

    $label = $group ? $group->label() : 'Undefined';


    $element['target_id'] = $element + [
        '#type' => 'value',
        '#default_value' => $group->id(),
        'label' => [
          '#type' => 'html_tag',
          '#tag' => 'h4',
          '#value' => $label,
          '#input' => FALSE,
        ],
      ];

    return $element;
  }

  public static function afterBuild(array $element, FormStateInterface $form_state) {
    $element = parent::afterBuild($element, $form_state);
    if (isset($element['add_more'])) {
      unset($element['add_more']);
    }
    return $element;
  }
}
