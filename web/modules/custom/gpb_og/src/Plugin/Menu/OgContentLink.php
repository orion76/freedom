<?php

namespace Drupal\gpb_og\Plugin\Menu;

use Drupal;
use Drupal\Core\Menu\MenuLinkDefault;
use Drupal\Core\Menu\StaticMenuLinkOverridesInterface;
use Drupal\Core\Routing\RedirectDestinationInterface;
use Drupal\gpb_og\Service\GpbOgContextInterface;
use Drupal\og\OgContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use function array_filter;
use function explode;

class OgContentLink extends MenuLinkDefault {

  /**
   * @var \Drupal\Core\Routing\RedirectDestinationInterface
   */
  private RedirectDestinationInterface $redirectDestination;

  /**
   * @var GpbOgContextInterface
   */
  private GpbOgContextInterface $ogContext;

  public function __construct(array $configuration,
                              $plugin_id,
                              $plugin_definition,
                              StaticMenuLinkOverridesInterface $static_override,
                              GpbOgContextInterface $ogContext) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $static_override);
    $this->ogContext = $ogContext;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('menu_link.static.overrides'),
      $container->get('gpb_og.context')

    );
  }

  public function getRouteParameters() {
    $parameters = parent::getRouteParameters();
    $parameters['group'] = $this->ogContext->getGroupId();
    return $parameters;
  }

}
