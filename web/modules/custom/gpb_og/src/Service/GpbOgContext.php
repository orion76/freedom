<?php

namespace Drupal\gpb_og\Service;

use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\og\OgContextInterface;
use function array_filter;
use function explode;
use function reset;

class GpbOgContext implements GpbOgContextInterface {

  /**
   * @var OgContextInterface
   */
  private OgContextInterface $ogContext;

  /**
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  private RouteMatchInterface $routeMatch;

  public function __construct(OgContextInterface $ogContext,
                              RouteMatchInterface $routeMatch) {
    $this->ogContext = $ogContext;
    $this->routeMatch = $routeMatch;
  }

  public function getGroupId() {
    if ($group = $this->ogContext->getGroup()) {
      return $group->id();
    }
    return $this->getGroupIdFromPath();
  }

  protected function getGroupIdFromPath() {

    $route = $this->routeMatch->getRouteObject();
    $path = $route->getPath();
    $path_parts = array_filter(explode('/', $path));


    if (reset($path_parts) === 'project') {
      return $this->routeMatch->getParameter('group');
    }
  }
}
