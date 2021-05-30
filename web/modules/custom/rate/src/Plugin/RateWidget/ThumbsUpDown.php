<?php

namespace Drupal\rate\Plugin\RateWidget;

use Drupal\rate\Plugin\RateWidgetInterface;
use Drupal\rate\Plugin\RateWidgetBase;


/**
 * The total number of positive votes.
 *
 * @RateWidget(
 *   id = "thumbs_up_down",
 *   label = @Translation("Thumbs Up-Down"),
 *   description = @Translation("Thumbs Up-Down.")
 * )
 */
class ThumbsUpDown extends RateWidgetBase implements RateWidgetInterface {

}
