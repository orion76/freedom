<?php


namespace Drupal\rate_alt\Services;


use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\user\UserInterface;
use Drupal\votingapi\VoteResultStorageInterface;
use Drupal\votingapi\VoteStorageInterface;
use Drupal\votingapi\VoteTypeInterface;

class VoteService implements VoteServiceInterface {

  /** @var EntityTypeManagerInterface */
  private $entityTypeManager;

  /** @var VoteStorageInterface */
  private $voteStorage;

  /** @var VoteResultStorageInterface */
  private $voteResultStorage;

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;

  }

  protected function getVoteStorage() {
    if (empty($this->voteStorage)) {
      $this->voteStorage = $this->entityTypeManager->getStorage('vote');
    }
    return $this->voteStorage;
  }

  protected function getVoteResultStorage() {
    if (empty($this->voteResultStorage)) {
      $this->voteResultStorage = $this->entityTypeManager->getStorage('vote_result');
    }
    return $this->voteResultStorage;
  }


  public function loadVote(VoteTypeInterface $voteType, EntityInterface $entity, UserInterface $user) {
    return $this->voteStorage->getUserVotes(
      $user->id(),
      $voteType->id(),
      $entity->getEntityTypeId(),
      $entity->id()
    );
  }

  public function loadVoteResult(VoteTypeInterface $voteType, EntityInterface $entity, $function) {
    return $this->voteResultStorage->getEntityResults(
      $entity->getEntityTypeId(),
      $entity->id(),
      $voteType->id(),
      $function
    );
  }

  public function createVote(VoteTypeInterface $voteType, EntityInterface $entity, UserInterface $user) {
    return $this->voteStorage->create([
      'type' => $voteType->id(),
      'entity_type' => $entity->getEntityTypeId(),
      'entity_id' => $entity->id(),
      'value_type' => $voteType->getValueType(),
      'user_id' => $user->id()]);
  }
}
