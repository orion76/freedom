<?php

namespace Drupal\rate\Controller;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Rate routes.
 */
class WidgetResultsController extends ControllerBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs an EntityUntranslatableFieldsConstraintValidator object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Display rate voting results views on nodes.
   *
   * @param \Drupal\node\NodeInterface $node
   *   The node for which to display results.
   *
   * @return array
   *   The render array.
   */
  public function nodeResults(NodeInterface $node) {
    $entity_type_id = $node->getEntityTypeId();
    $bundle = $node->bundle();
    // First, make sure the data is fresh.
    $cache_bins = Cache::getBins();
    $cache_bins['data']->deleteAll();

    // Check if the node has widgets enabled.
    $widgets = $this->entityTypeManager->getStorage('rate_widget_config')->loadMultiple();
    if (!empty($widgets)) {
      foreach ($widgets as $widget => $widget_variables) {
        $entities = $widget_variables->get('entity_types');
        if ($entities && count($entities) > 0) {
          foreach ($entities as $entity) {
            if ($entity == $entity_type_id . '.' . $bundle) {
              // Get and return the rate results views.
              $page[] = ['#type' => '#markup', '#markup' => '<strong>' . $widget_variables->label() . '</strong>'];
              $page[] = views_embed_view('rate_widgets_results', 'node_summary_block', $node->id(), $node->getEntityTypeId(), $widget);
              $page[] = views_embed_view('rate_widgets_results', 'node_results_block', $node->id(), $node->getEntityTypeId(), $widget);
            }
          }
        }
      }
    }
    return $page;
  }

}
