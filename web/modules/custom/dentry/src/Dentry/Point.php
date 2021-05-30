<?php

namespace Drupal\dentry\Dentry;

use Drupal\Core\Config\Entity\ConfigEntityBase;

abstract class Point extends ConfigEntityBase implements PointInterface {

  /**
   * The Point ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Point label.
   *
   * @var string
   */
  protected $label;

  protected $code;

  protected $parent_id;

  /**
   * Активный, Пассивный, Активно-пассивный счет
   *
   * @var
   */
  protected $account_type;

  /**
   * Балансовый(balance), Забалансовый счет(off_balance)
   *
   * @var
   */
  protected $account_item;
  
  
  protected $subconto;

}
