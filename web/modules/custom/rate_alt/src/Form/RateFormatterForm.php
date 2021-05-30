<?php


use Drupal\Component\Datetime\TimeInterface;
use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\votingapi\Entity\Vote;
use Drupal\votingapi\VoteResultFunctionManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RateFormatterForm extends ContentEntityForm {

  /**
   * The time service.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * The votingapi result manager.
   *
   * @var \Drupal\votingapi\VoteResultFunctionManager
   */
  protected $votingapiResult;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $account;

  /**
   * The logger instance.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * The config factory wrapper to fetch settings.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $config;

  /**
   * Constructs a RateWidgetBaseForm object.
   *
   * @param \Drupal\Core\Entity\EntityRepositoryInterface $entity_repository
   *   The entity repository.
   * @param \Drupal\Core\Entity\EntityTypeBundleInfoInterface $entity_type_bundle_info
   *   The entity type bundle service.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time service.
   * @param \Drupal\votingapi\VoteResultFunctionManager $votingapi_result
   *   Vote result function service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   Entity type manager service.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The account service.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(EntityRepositoryInterface $entity_repository,
                              EntityTypeBundleInfoInterface $entity_type_bundle_info,
                              TimeInterface $time,
                              VoteResultFunctionManager $votingapi_result,
                              EntityTypeManagerInterface $entity_type_manager,
                              AccountInterface $account,
                              LoggerInterface $logger,
                              ConfigFactoryInterface $config_factory) {
    parent::__construct($entity_repository, $entity_type_bundle_info, $time);
    $this->time = $time;
    $this->votingapiResult = $votingapi_result;
    $this->entityTypeManager = $entity_type_manager;
    $this->account = $account;
    $this->logger = $logger;
    $this->config = $config_factory->get('rate.settings');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.repository'),
      $container->get('entity_type.bundle.info'),
      $container->get('datetime.time'),
      $container->get('plugin.manager.votingapi.resultfunction'),
      $container->get('entity_type.manager'),
      $container->get('current_user'),
      $container->get('logger.factory')->get('rate'),
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    $entity = $this->getEntity();
    $voted_entity_type = $entity->getVotedEntityType();
    $voted_entity_id = $entity->getVotedEntityId();
    $voted_entity = $this->entityTypeManager->getStorage($voted_entity_type)->load($voted_entity_id);

    $additional_form_id_parts = [];
    $additional_form_id_parts[] = $voted_entity->getEntityTypeId();
    $additional_form_id_parts[] = $voted_entity->bundle();
    $additional_form_id_parts[] = $voted_entity->id();
    $additional_form_id_parts[] = $entity->bundle();
    $additional_form_id_parts[] = $entity->rate_widget->value;
    $form_id = implode('_', $additional_form_id_parts);

    return $form_id;
  }

  private function getSettings() {
    /*
    * @TODO 
    */
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $form['#theme']='rate_formatter_form';
    /** @var $vote_entity Vote */
    $vote_entity = $this->getEntity();

    $voted_entity_type = $vote_entity->getVotedEntityType();
    $voted_entity_id = $vote_entity->getVotedEntityId();
    $voted_entity = $this->entityTypeManager->getStorage($voted_entity_type)->load($voted_entity_id);
    $settings = $this->getSettings();

    $form['#cache']['contexts'][] = 'user.permissions';
    $form['#cache']['contexts'][] = 'user.roles:authenticated';

    $vote_input_type = NestedArray::keyExists($settings, ['vote', 'input']) ?
      NestedArray::getValue($settings, ['vote', 'input']) :
      'hidden';


    $form['vote'] = [
      '#type' => $vote_input_type,
      '#value' => $vote_entity->isNew() ? NULL : (int) $vote_entity->getValue(),
      '#attributes' => [
        'data-user-vote-value' => 'true',
      ],
    ];

    switch ($vote_input_type) {
      case 'radios':
        $form['vote']['#options'] = $settings['vote']['variants'];
        break;
    }

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state, $display_readonly = FALSE, $deadline_disabled = FALSE) {
    $entity = $this->getEntity();
    $plugin = $form_state->get('plugin');
    $is_bot_vote = $plugin->isBotVote();

    if ($plugin->canVote($entity) && !$is_bot_vote) {
      if ($display_readonly === FALSE || $deadline_disabled = FALSE) {
        $return = parent::save($form, $form_state);
        // @todo: Could be simplified if https://www.drupal.org/project/votingapi/issues/3159592 was done.
        $voted_entity_id = $entity->getVotedEntityId();
        $voted_entity_type_id = $entity->getVotedEntityType();
        $voted_entity = $this->entityTypeManager->getStorage($voted_entity_type_id)->load($voted_entity_id);
        Cache::invalidateTags(['vote:' . $voted_entity->bundle() . ':' . $voted_entity_id]);
        return $return;
      }
    }
    return FALSE;
  }


}
