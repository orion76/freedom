<?php

namespace Drupal\freedom_group\Service;

use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use function strpos;

class GroupPages implements GroupPagesInterface {

  use StringTranslationTrait;

  /**
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  private RouteMatchInterface $route_match;

  /**
   * @var \Drupal\Core\Entity\EntityTypeBundleInfoInterface
   */
  private EntityTypeBundleInfoInterface $bundle_info;

  public function __construct(RouteMatchInterface $route_match, EntityTypeBundleInfoInterface $bundle_info) {
    $this->route_match = $route_match;
    //current_route_match
    $this->bundle_info = $bundle_info;
  }


  public function isGroupPage() {
    return strpos($this->getRoute()->getPath(), '/group/{group}') === 0;
  }

  /**
   * @return \Symfony\Component\Routing\Route|null
   */
  private function getRoute() {
    return $this->route_match->getRouteObject();
  }

  public function isGroupCanonical() {
    return $this->route_match->getRouteName() === 'entity.group.canonical';
  }

  private function getBundleName($entity_type, $bundle) {
    $bundles = $this->bundle_info->getBundleInfo($entity_type);
    return $bundles[$bundle]['label'];
  }

  public function getPageInfo() {
    $info = [];
    $path = $this->getRoute()->getPath();
    $group = $this->route_match->getParameter('group');
    if ($view_id = $this->route_match->getParameter('view_id')) {
      $info['type'] = 'list';
      switch ($view_id) {
        case 'group_project_tasks':
          $info['entity_type'] = 'node';
          $info['bundle'] = 'group_task';
          $info['title'] = 'Задачи';
          $info['route'] = 'view.group_project_tasks.page_1';
          $info['parameters'] = ['group' => $group->id()];
          break;

        case 'group_project_materials':
          $info['entity_type'] = 'node';
          $info['bundle'] = 'group_material';
          $info['title'] = 'Материалы';
          $info['route'] = 'view.group_project_materials.page_1';
          $info['parameters'] = ['group' => $group->id()];

          break;
        case 'group__task_status':
          $info['entity_type'] = 'taxonomy_term';
          $info['bundle'] = 'group__task_status';
          $info['title'] = 'Статусы';
          $info['route'] = 'view.group__task_status.page_1';
          $info['parameters'] = ['group' => $group->id()];
          break;
        case 'group__section':
          $info['entity_type'] = 'taxonomy_term';
          $info['bundle'] = 'group__section';
          $info['title'] = 'Разделы';
          $info['route'] = 'view.group__section.page_1';
          $info['parameters'] = ['group' => $group->id()];
          break;
        case 'group_members':
          $info['entity_type'] = 'user';
          $info['bundle'] = 'user';
          $info['title'] = 'Разделы';
          $info['route'] = 'view.group_members.page_1';
          $info['parameters'] = ['group' => $group->id()];
          break;
      }
    }

    return $info;
  }

  /**
   * @return \Drupal\group\Entity\GroupInterface
   */
  public function getGroup() {
    return $this->route_match->getParameter('group');
  }
}
