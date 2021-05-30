<?php

namespace Drupal\dentry\Services;

use Drupal\Core\Entity\EntityInterface;

interface EntryServiceInterface {


  public function doEntry(EntityInterface $entity);
}
