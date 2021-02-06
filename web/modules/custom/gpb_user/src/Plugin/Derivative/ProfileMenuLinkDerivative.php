<?php

namespace Drupal\gpb_user\Plugin\Derivative;


use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProfileMenuLinkDerivative extends DeriverBase implements ContainerDeriverInterface {

    /**
     * @var EntityTypeManagerInterface $entityTypeManager .
     */
    protected $entityTypeManager;

    /** @var EntityTypeBundleInfoInterface */
    protected $bundleInfo;

    /**
     * Creates a ProductMenuLink instance.
     *
     * @param $base_plugin_id
     * @param EntityTypeManagerInterface $entity_type_manager
     */
    public function __construct($base_plugin_id,
                                EntityTypeManagerInterface $entity_type_manager,
                                EntityTypeBundleInfoInterface $bundleInfo) {
        $this->entityTypeManager = $entity_type_manager;
        $this->bundleInfo = $bundleInfo;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, $base_plugin_id) {
        return new static(
            $base_plugin_id,
            $container->get('entity_type.manager'),
            $container->get('entity_type.bundle.info'),

        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDerivativeDefinitions($base_plugin_definition) {
        $links = [];
        $route_name = "profile.user_page.single";
        $bundles = $this->bundleInfo->getBundleInfo('profile');
        foreach ($bundles as $id => $profile) {
            $links[$id] = [
                'title' => $profile['label'],
                'route_name' => $route_name,
                'route_parameters' => ['profile_type' => $id],
            ]+ $base_plugin_definition;
        }
        return $links;
    }
}
