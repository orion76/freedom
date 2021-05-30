<?php

namespace Drupal\rate_alt\Plugin\Field\FieldType;


use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinitionInterface;
use Drupal\Core\TypedData\DataReferenceDefinition;
use Drupal\Core\TypedData\TraversableTypedDataInterface;
use Drupal\Core\TypedData\TypedDataInterface;
use Drupal\rate_alt\Plugin\RateWidgetInterface;
use Drupal\rate_alt\Plugin\RateWidgetManagerInterface;
use Drupal\rate_alt\Services\VoteServiceInterface;
use Drupal\votingapi\VoteResultFunctionManager;
use function count;
use function reset;
use function t;

/**
 * Plugin implementation of the 'rate_field_type' field type.
 *
 * @FieldType(
 *   id = "rate_field_type",
 *   label = @Translation("Rate"),
 *   description = @Translation("Rate field type"),
 *   category = @Translation("Rate"),
 *   deriver = "\Drupal\rate_alt\Plugin\Derivative\FieldTypeRateDeriver",
 *   list_class = "\Drupal\rate_alt\Plugin\RateFieldItemList",
 *   default_widget = "rate_widget_type",
 *   default_formatter = "rate_formatter_number",
 *   cardinality = 1,
 *   custom_storage = TRUE,
 * )
 */
class RateFieldType extends FieldItemBase implements RateFieldTypeInterface {

  protected $isCalculated = FALSE;

  /** @var VoteServiceInterface */
  protected $voteService;


  /** @var VoteResultFunctionManager */
  protected $voteFunctionManager;

  public function __construct(DataDefinitionInterface $definition,
                              VoteResultFunctionManager $voteFunctionManager,
                              VoteServiceInterface $voteService,
                              $name = NULL,
                              TypedDataInterface $parent = NULL
  ) {
    parent::__construct($definition, $name, $parent);
    $this->voteService = $voteService;
    $this->voteFunctionManager = $voteFunctionManager;
  }


  public static function createInstance($definition, $name = NULL, TraversableTypedDataInterface $parent = NULL) {
    return new static(
      $definition,
      \Drupal::service('plugin.manager.votingapi.resultfunction'),
      \Drupal::service('rate_alt.vote_service'),
      $name,
      $parent);
  }

  public static function defaultFieldSettings() {
    return [
        'vote_function' => '',
      ] + parent::defaultFieldSettings();
  }

  public static function defaultStorageSettings() {
    return ['custom_storage' => TRUE];
  }

  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    $element = [];
    $settings = $this->getSettings();

    $options = array_column($this->voteFunctionManager->getDefinitions(), 'label');

    $element['vote_function'] = [
      '#type' => 'select',
      '#title' => t('Vote function'),
      '#default_value' => $settings['vote_function'],
      '#options' => $options,
      '#required' => TRUE,
      '#empty_option' => $this->t('- Select -'),
      '#description' => t('Function plugin for vote result calculate.'),
    ];

    return $element;
  }

  public function getVoteResult() {
    $entity = $this->getEntity();
    $results = $this->voteResultStorage->getEntityResults(
      $entity->getEntityTypeId(),
      $entity->id(),
      $this->get('vote_type'),
      $this->get('vote_function'),
    );
    return count($results) === 1 ? reset($results) : NULL;
  }


  public function getVoteTypeEntity() {
    if (empty($this->voteTypeEntity)) {
      $this->voteTypeEntity = $this->getRatePlugin()->getVoteType();
    }
    return $this->voteTypeEntity;
  }

  public function createVote($value) {
    $account = \Drupal::currentUser()->getAccount();
    $entity = $this->getEntity();
    $vote = $this->voteStorage->create([
        'user_id' => $account->id(),
        'type' => $this->get('vote_type'),
        'entity_type' => $entity->getEntityTypeId(),
        'entity_id' => $entity->id(),
        //        'value'=>,
        //        'value_type'=>,
      ]

    );
    return $vote;
  }

  public function getVoteFunction() {
    $this->definition['vote_function'];
  }

  public function getVote() {
    $account = \Drupal::currentUser()->getAccount();
    $entity = $this->getEntity();
    $results = $this->voteStorage->getUserVotes(
      $account->id(),
      $this->get('vote_type'),
      $entity->getEntityTypeId(),
      $entity->id()
    );
    return count($results) === 1 ? reset($results) : NULL;
  }


  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {

    $field_definition->custom_storage = TRUE;

    $properties['vote_type'] = DataReferenceDefinition::create('entity')
      ->setLabel(new TranslatableMarkup('Vote type'))
      ->setDescription(new TranslatableMarkup('The vote type'))
      ->setComputed(TRUE);


    $properties['vote_result'] = DataReferenceDefinition::create('entity')
      ->setLabel(new TranslatableMarkup('Vote result'))
      ->setDescription(new TranslatableMarkup('The vote result'))
      ->setComputed(TRUE);


    $properties['user_vote'] = DataReferenceDefinition::create('entity')
      ->setLabel(new TranslatableMarkup('User vote'))
      ->setDescription(new TranslatableMarkup('The user vote '))
      ->setComputed(TRUE);

    return $properties;
  }


  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [];
  }


  /**
   * {@inheritdoc}
   */
  public function __get($name) {
    $this->ensureCalculated();
    return parent::__get($name);
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $this->ensureCalculated();
    return parent::isEmpty();
  }

  /**
   * {@inheritdoc}
   */
  public function getValue() {
    $this->ensureCalculated();
    return parent::getValue();
  }

  /**
   * Calculates the value of the field and sets it.
   */
  protected function ensureCalculated() {
    if (!$this->isCalculated) {
      $entity = $this->getEntity();
      if (!$entity->isNew()) {
        $value = [
          'vote_type' => '',
          'vote_result' => '',
          'user_vote' => '',
        ];
        $this->setValue($value);
      }
      $this->isCalculated = TRUE;
    }
  }
}
