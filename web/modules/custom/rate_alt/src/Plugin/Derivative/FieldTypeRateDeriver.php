<?php

namespace Drupal\rate_alt\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\votingapi\VoteTypeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FieldTypeRateDeriver extends DeriverBase implements ContainerDeriverInterface{

  use StringTranslationTrait;

  /** @var EntityTypeManagerInterface */
  private $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $base_plugin_id) {
    return new static(
      $container->get('entity_type.manager')
    );
  }


  public function getDerivativeDefinitions($base_plugin_definition) {
    foreach ($this->entityTypeManager->getStorage('vote_type')->loadMultiple() as $voteType) {
      /** @var $voteType VoteTypeInterface */
      $type_id = $voteType->id();
      $this->derivatives[$type_id] = $base_plugin_definition;
      $this->derivatives[$type_id]['admin_label'] = $this->t('Rate @vote_type_label', ['@vote_type_label' => $voteType->label()]);
      $this->derivatives[$type_id]['label'] = $this->t('Rate @vote_type_label', ['@vote_type_label' => $voteType->label()]);
    }

    return $this->derivatives;
  }
}
