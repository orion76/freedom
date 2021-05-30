<?php

namespace Drupal\rate_alt\Plugin\Field\FieldType;


interface RateFieldTypeInterface {

  public function getVoteResult();

  public function getVoteTypeEntity();

  public function createVote($value);

  public function getVote();

  public function getVoteFunction();
}
