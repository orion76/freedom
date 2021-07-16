<?php

namespace Drupal\freedom_group\Service;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Link;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use function strlen;
use function strpos;

class GroupBreadcrumb implements BreadcrumbBuilderInterface {

  use StringTranslationTrait;

  /**
   * @var \Drupal\freedom_group\Service\GroupPagesInterface
   */
  private GroupPagesInterface $group_pages;

  public function __construct(GroupPagesInterface $group_pages) {
    $this->group_pages = $group_pages;
  }

  public function applies(RouteMatchInterface $route_match) {
    return $this->group_pages->isGroupPage();
  }

  public function build(RouteMatchInterface $route_match) {
    $breadcrumb = new Breadcrumb();
    $breadcrumb->addLink(Link::createFromRoute($this->t('Home'), '<front>'));
    $breadcrumb->addLink(Link::createFromRoute('Проекты', 'view.projects.page_1'));


    if (!$this->group_pages->isGroupCanonical()) {
      /** @var \Drupal\group\Entity\GroupInterface $group */
      $group = $route_match->getParameter('group');
      $breadcrumb->addLink(Link::createFromRoute($group->label(), 'entity.group.canonical', ['group' => $group->id()]));
      $breadcrumb->addCacheableDependency($group);
      $info = $this->group_pages->getPageInfo();
      if(empty($info)){
        return $breadcrumb;
      }
      switch ($info['type']) {

        case 'list':
          $route = Link::createFromRoute($info['title'], $info['route'], $info['parameters']);
          $breadcrumb->addLink($route);
          break;

        case 'add_form':

          break;

        case 'create_form':

          break;
      }
    }
    $breadcrumb->addCacheContexts(['route']);
    return $breadcrumb;
  }
}
