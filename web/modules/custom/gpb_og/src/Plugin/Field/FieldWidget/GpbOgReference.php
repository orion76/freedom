<?php

namespace Drupal\gpb_og\Plugin\Field\FieldWidget;

use Drupal;
use Drupal\Component\Utility\Html;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldFilteredMarkup;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\og\Plugin\Field\FieldWidget\OgComplex;
use Symfony\Component\DependencyInjection\ContainerInterface;
use function array_filter;
use function array_map;
use function array_merge;
use function count;
use function get_class;
use function implode;
use function in_array;
use function is_int;
use function preg_match;

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
class GpbOgReference extends OgComplex {

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
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    if (!static::isFieldModeView($element)) {
      $element['#field_mode'] = 'edit';
      return parent::formElement($items, $delta, $element, $form, $form_state);
    }
    $element['#field_mode'] = 'view';
    $entity = $items->getEntity();
    if ($entity->isNew() && $group_id = Drupal::request()->query->get('og_group_id')) {
      $entity_type = $this->fieldDefinition->getTargetEntityTypeId();
      $group = $this->entityTypeManager->getStorage($entity_type)->load($group_id);
    } else {
      $referenced_entities = $items->referencedEntities();
      $group = isset($referenced_entities[$delta]) ? $referenced_entities[$delta] : NULL;
    }

    if ($group) {
      $element['target_id'] = $element + [
          '#type' => 'value',
          '#default_value' => $group->id(),
          'label' => [
            '#type' => 'html_tag',
            '#tag' => 'h4',
            '#value' => $group->label(),
            '#input' => FALSE,
          ],
        ];

    } else {

      $element['target_id'] = $element + [
          '#type' => 'value',
          '#default_value' => '',
          'label' => [
            '#type' => 'html_tag',
            '#tag' => 'h4',
            '#value' => 'Undefined',
            '#input' => FALSE,
          ],
        ];

    }


    return $element;
  }

  public function form(FieldItemListInterface $items, array &$form, FormStateInterface $form_state, $get_delta = NULL) {
    $field_name = $this->fieldDefinition->getName();
    $parents = $form['#parents'];

    // Store field information in $form_state.
    if (!static::getWidgetState($parents, $field_name, $form_state)) {
      $count = count($items) - 1;
      $field_state = [
        'items_count' => $count < 0 ? 0 : $count,
        'array_parents' => [],
      ];
      static::setWidgetState($parents, $field_name, $form_state, $field_state);
    }

    $parent_form = parent::form($items, $form, $form_state, $get_delta);

    if (isset($parent_form['other_groups'])) {
      unset($parent_form['other_groups']);
    }
    return $parent_form;
  }

  public static function afterBuild(array $element, FormStateInterface $form_state) {
    $element = parent::afterBuild($element, $form_state);
    if (static::isFieldModeView($element) && isset($element['add_more'])) {
      unset($element['add_more']);
    }
    return $element;
  }

  /**
   * Special handling to create form elements for multiple values.
   *
   * Handles generic features for multiple fields:
   * - number of widgets
   * - AHAH-'add more' button
   * - table display and drag-n-drop value reordering.
   */
  protected function formMultipleElements(FieldItemListInterface $items, array &$form, FormStateInterface $form_state) {
    $field_name = $this->fieldDefinition->getName();
    $cardinality = $this->fieldDefinition->getFieldStorageDefinition()->getCardinality();
    $parents = $form['#parents'];

    $target_type = $this->fieldDefinition->getFieldStorageDefinition()->getSetting('target_type');

    /** @var \Drupal\og\MembershipManagerInterface $membership_manager */
    $membership_manager = Drupal::service('og.membership_manager');
    $user_groups = $membership_manager->getUserGroups(Drupal::currentUser()->id());
    $user_groups_target_type = isset($user_groups[$target_type]) ? $user_groups[$target_type] : [];
    $user_group_ids = array_map(function ($group) {
      return $group->id();
    }, $user_groups_target_type);

    // Determine the number of widgets to display.
    switch ($cardinality) {
      case FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED:
        $field_state = static::getWidgetState($parents, $field_name, $form_state);
        $max = $field_state['items_count'];
        $is_multiple = TRUE;
        break;

      default:
        $max = $cardinality - 1;
        $is_multiple = ($cardinality > 1);
        break;
    }

    $title = $this->fieldDefinition->getLabel();
    $description = FieldFilteredMarkup::create(Drupal::token()->replace($this->fieldDefinition->getDescription()));

    $elements = [];

    for ($delta = 0; $delta <= $max; $delta++) {
      // Add a new empty item if it doesn't exist yet at this delta.
      if (!isset($items[$delta])) {
        $items->appendItem();
      } elseif (!empty($items[$delta]->get('target_id')->getValue()) && !in_array($items[$delta]->get('target_id')
          ->getValue(), $user_group_ids)) {
        continue;
      }

      // For multiple fields, title and description are handled by the wrapping
      // table.
      if ($is_multiple) {
        $element = [
          '#title' => $this->t('@title (value @number)', [
            '@title' => $title,
            '@number' => $delta + 1,
          ]),
          '#title_display' => 'invisible',
          '#description' => '',
        ];
      } else {
        $element = [
          '#title' => $title,
          '#title_display' => 'before',
          '#description' => $description,
        ];
      }

      $element = $this->formSingleElement($items, $delta, $element, $form, $form_state);

      if ($element) {
        // Input field for the delta (drag-n-drop reordering).
        if ($is_multiple) {
          // We name the element '_weight' to avoid clashing with elements
          // defined by widget.
          $element['_weight'] = [
            '#type' => 'weight',
            '#title' => $this->t('Weight for row @number', ['@number' => $delta + 1]),
            '#title_display' => 'invisible',
            // Note: this 'delta' is the FAPI #type 'weight' element's property.
            '#delta' => $max,
            '#default_value' => $items[$delta]->_weight ?: $delta,
            '#weight' => 100,
          ];
        }

        $elements[$delta] = $element;
      }
    }

    if ($elements) {
      $elements += [
        '#theme' => 'field_multiple_value_form',
        '#field_name' => $field_name,
        '#cardinality' => $cardinality,
        '#cardinality_multiple' => $this->fieldDefinition->getFieldStorageDefinition()->isMultiple(),
        '#required' => $this->fieldDefinition->isRequired(),
        '#title' => $title,
        '#description' => $description,
        '#max_delta' => $max,
      ];

      // Add 'add more' button, if not working with a programmed form.
      if ($cardinality == FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED && !$form_state->isProgrammed()) {
        $id_prefix = implode('-', array_merge($parents, [$field_name]));
        $wrapper_id = Html::getUniqueId($id_prefix . '-add-more-wrapper');
        $elements['#prefix'] = '<div id="' . $wrapper_id . '">';
        $elements['#suffix'] = '</div>';

        $elements['add_more'] = [
          '#type' => 'submit',
          '#name' => strtr($id_prefix, '-', '_') . '_add_more',
          '#value' => $this->t('Add another item'),
          '#attributes' => ['class' => ['field-add-more-submit']],
          '#limit_validation_errors' => [array_merge($parents, [$field_name])],
          '#submit' => [[get_class($this), 'addMoreSubmit']],
          '#ajax' => [
            'callback' => [get_class($this), 'addMoreAjax'],
            'wrapper' => $wrapper_id,
            'effect' => 'fade',
          ],
        ];
      }
    }

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    // Remove empty values. The form fields may be empty.
    $values = array_filter($values, function ($item) {
      return !empty($item['target_id']);
    });

    if (!isset($form[$this->fieldDefinition->getName()])) {
      return $values;
    }

    // Get the groups from the other groups widget.
    foreach ($form[$this->fieldDefinition->getName()]['other_groups'] as $key => $value) {
      if (!is_int($key)) {
        continue;
      }

      // Matches the entity label and ID. E.g. 'Label (123)'. The entity ID will
      // be captured in it's own group, with the key 'id'.
      preg_match("|.+\((?<id>[\w.]+)\)|", $value['target_id']['#value'], $matches);

      if (!empty($matches['id'])) {
        $values[] = [
          'target_id' => $matches['id'],
          '_weight' => $value['_weight']['#value'],
          '_original_delta' => $value['_weight']['#delta'],
        ];
      }
    }

    return $values;
  }


  private static function isFieldModeView($element) {
    $parents = $element['#field_parents'];
    return empty($parents) || $parents[0] !== 'default_value_input';
  }
}
