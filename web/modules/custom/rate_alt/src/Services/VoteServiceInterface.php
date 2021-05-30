<?php

namespace Drupal\rate_alt\Services;

use Drupal\Core\Entity\EntityInterface;
use Drupal\user\UserInterface;
use Drupal\votingapi\VoteTypeInterface;

interface VoteServiceInterface {

  public function loadVote(VoteTypeInterface $voteType, EntityInterface $entity, UserInterface $user);

  public function loadVoteResult(VoteTypeInterface $voteType, EntityInterface $entity, $function);

  public function createVote(VoteTypeInterface $voteType, EntityInterface $entity, UserInterface $user);
}
