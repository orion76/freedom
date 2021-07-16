<?php

namespace Drupal\freedom_group\Plugin\views\argument_default;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Cache\CacheableDependencyInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\group\Entity\GroupInterface;
use Drupal\group\Entity\Storage\GroupContentStorageInterface;
use Drupal\views\Plugin\views\argument_default\ArgumentDefaultPluginBase;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use function reset;

/**
 * Default argument plugin to extract a node.
 *
 * @ViewsArgumentDefault(
 *   id = "entity_group",
 *   title = @Translation("Group ID from entity")
 * )
 */
class EntityGroup extends ArgumentDefaultPluginBase implements CacheableDependencyInterface {

  /**
   * The route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /** @var  GroupContentStorageInterface */
  private $groupStorage;

  /**
   * Constructs a new Node instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match.
   */
  public function __construct(array $configuration, 
                              $plugin_id, 
                              $plugin_definition,
                              RouteMatchInterface $route_match,
                              EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->routeMatch = $route_match;
    $this->groupStorage = $entityTypeManager->getStorage('group_content');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_route_match'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getArgument() {
    if (($group = $this->getGroupFromEntity()) && $group instanceof GroupInterface) {
      return $group->id();
    }
  }

  private function getGroupFromEntity() {
    if ($node = $this->routeMatch->getParameter('node')) {
      /** @var $group_content \Drupal\group\Entity\GroupContentInterface[] */
      $group_content = $this->groupStorage->loadByEntity($node);
      if(empty($group_content)){
        return NULL;
      }
      $group_content=reset($group_content);
      return $group_content->getGroup();
    }
  }
  
  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return Cache::PERMANENT;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return ['url'];
  }

}
