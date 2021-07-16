<?php

namespace Drupal\freedom_group\EventSubscriber;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\group\Entity\Storage\GroupContentStorageInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpKernel\Event\FilterControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelSubscriber implements EventSubscriberInterface {

  /** @var  GroupContentStorageInterface */
  private $groupStorage;

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->groupStorage = $entityTypeManager->getStorage('group_content');
  }

  /**
   * {@inheritdoc}
   */
  public function onKernelRequest(GetResponseEvent $event) {
    $request = $event->getRequest();
    if ($group = $this->getGroupFromEntity($request->attributes)) {
      $request->attributes->set('group', $group->id());
    }
  }

  private function getGroupFromEntity(ParameterBag $attributes) {
    if ($node = $attributes->get('node')) {
      /** @var $group_content \Drupal\group\Entity\GroupContentInterface[] */
      $group_content = $this->groupStorage->loadByEntity($node);
      if(empty($group_content)){
        return NULL;
      }
      $group_content=reset($group_content);
      return $group_content->getGroup();
    }
  }

  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['onKernelRequest',-300];
//    $events[KernelEvents::CONTROLLER_ARGUMENTS][] = 'onKernelRequest';
    return $events;
  }
}
