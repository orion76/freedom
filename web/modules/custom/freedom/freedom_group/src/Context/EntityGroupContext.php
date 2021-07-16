<?php

namespace Drupal\freedom_group\Context;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\Context\Context;
use Drupal\Core\Plugin\Context\ContextProviderInterface;
use Drupal\Core\Plugin\Context\EntityContext;
use Drupal\Core\Plugin\Context\EntityContextDefinition;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\group\Entity\Storage\GroupContentStorageInterface;

/**
 * Sets the current group as a context on group routes.
 */
class EntityGroupContext implements ContextProviderInterface {

  use StringTranslationTrait;

  /**
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  private RouteMatchInterface $currentRouteMatch;

  private EntityTypeManagerInterface $entityTypeManager;

  /** @var  GroupContentStorageInterface */
  private $groupStorage;

  /**
   * Constructs a new GroupRouteContext.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $current_route_match
   *   The current route match object.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(RouteMatchInterface $current_route_match, 
                              EntityTypeManagerInterface $entity_type_manager) {
    $this->currentRouteMatch = $current_route_match;
    $this->entityTypeManager = $entity_type_manager;

    $this->groupStorage = $entity_type_manager->getStorage('group_content');

  }


  /**
   * {@inheritdoc}
   */
  public function getRuntimeContexts(array $unqualified_context_ids) {
    // Create an optional context definition for group entities.
    $context_definition = EntityContextDefinition::fromEntityTypeId('group')
      ->setRequired(FALSE);

    // Cache this context per group on the route.
    $cacheability = new CacheableMetadata();
    $cacheability->setCacheContexts(['route.group']);

    // Create a context from the definition and retrieved or created group.
    $context = new Context($context_definition, $this->getGroupFromEntity());
    $context->addCacheableDependency($cacheability);

    return ['entity_group' => $context];
  }

  /**
   * {@inheritdoc}
   */
  public function getAvailableContexts() {
    return ['entity_group' => EntityContext::fromEntityTypeId('group', $this->t('Group from entity'))];
  }

  private function getGroupFromEntity() {
    if ($node = $this->currentRouteMatch->getParameter('node')) {
      /** @var $group_content \Drupal\group\Entity\GroupContentInterface   */ 
      $group_content = $this->groupStorage->loadByEntity($node);
      return $group_content->getGroup();
    }
  }

}
