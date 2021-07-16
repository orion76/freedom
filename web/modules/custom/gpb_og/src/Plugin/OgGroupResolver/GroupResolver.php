<?php


namespace Drupal\gpb_og\Plugin\OgGroupResolver;

use Drupal\og\OgResolvedGroupCollectionInterface;
use Drupal\og\OgRouteGroupResolverBase;

/**
 * Resolves the group from the route.
 *
 * This plugin inspects the current route and checks if it is an entity path for
 * a group entity.
 *
 * @OgGroupResolver(
 *   id = "route_parameter_group",
 *   label = "Group entity from current route",
 *   description = @Translation("Checks if the current route is an entity path that belongs to a group entity.")
 * )
 */
class GroupResolver extends OgRouteGroupResolverBase {

  /**
   * {@inheritdoc}
   */
  public function resolve(OgResolvedGroupCollectionInterface $collection) {
    $entity = $this->getContentEntity();
    if ($entity && $this->groupTypeManager->isGroup($entity->getEntityTypeId(), $entity->bundle())) {
      $collection->addGroup($entity, ['route']);
      $this->stopPropagation();
    }
  }

  protected function getContentEntity() {
    $route = $this->routeMatch->getRouteObject();
    if (!$route) {
      return NULL;
    }
    // Check if we are on a content entity path.
    // Return the entity.
    return $this->routeMatch->getParameter('group');
  }
}
