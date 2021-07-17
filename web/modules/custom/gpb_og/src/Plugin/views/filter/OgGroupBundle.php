<?php

namespace Drupal\gpb_og\Plugin\views\filter;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\filter\InOperator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use function asort;


/**
 * Filter class which allows filtering by entity bundles.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("og_group_bundle")
 */
class OgGroupBundle extends InOperator {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  private EntityTypeManagerInterface $entityTypeManager;

  public function __construct(array $configuration,
                              $plugin_id,
                              $plugin_definition,
                              EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entityTypeManager;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

  public function query() {
    // Make sure that the entity base table is in the query.
    $this->ensureMyTable();
    parent::query();
  }
  /**
   * {@inheritdoc}
   */
  public function getValueOptions() {
    if (!isset($this->valueOptions)) {
      $types = $this->entityTypeManager->getDefinitions();

      $options = [];
      foreach ($types as $type) {
        /** @var $type \Drupal\Core\Entity\EntityTypeInterface */
        $options[$type->id()] = $type->getLabel();
      }

      asort($options);
      $this->valueOptions = $options;
    }

    return $this->valueOptions;
  }
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
    if ($this->canExpose()) {
      $this->showExposeButton($form, $form_state);
    }
    if ($this->canBuildGroup()) {
      $this->showBuildGroupButton($form, $form_state);
    }
    $form['clear_markup_start'] = [
      '#markup' => '<div class="clearfix">',
    ];
    if ($this->isAGroup()) {
      if ($this->canBuildGroup()) {
        $form['clear_markup_start'] = [
          '#markup' => '<div class="clearfix">',
        ];
        // Render the build group form.
        $this->showBuildGroupForm($form, $form_state);
        $form['clear_markup_end'] = [
          '#markup' => '</div>',
        ];
      }
    }
    else {
      // Add the subform from operatorForm().
      $this->showOperatorForm($form, $form_state);
      // Add the subform from valueForm().
      $this->showValueForm($form, $form_state);
      $form['clear_markup_end'] = [
        '#markup' => '</div>',
      ];
      if ($this->canExpose()) {
        // Add the subform from buildExposeForm().
        $this->showExposeForm($form, $form_state);
      }
    }
  }

}
