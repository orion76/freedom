<?php
namespace Drupal\rate_alt\Plugin;

use Drupal\Core\Field\FieldItemList;
use Drupal\Core\TypedData\ComputedItemListTrait;

class RateFieldItemList extends FieldItemList{
  use ComputedItemListTrait;

  protected function computeValue() {
    // TODO: Implement computeValue() method.
  }

  protected function ensurePopulated() {
    if (!isset($this->list[0])) {
      $this->list[0] = $this->createItem(0);
    }
  }
}
