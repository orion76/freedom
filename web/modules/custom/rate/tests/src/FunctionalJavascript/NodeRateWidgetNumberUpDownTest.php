<?php

namespace Drupal\Tests\rate\FunctionalJavascript;

use Drupal\rate\Entity\RateWidgetConfig;

/**
 * Tests for the "Number Up / Down" widget.
 *
 * @group rate
 */
class NodeRateWidgetNumberUpDownTest extends NodeRateWidgetTestBase {

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    // Create the rate widget.
    $options = [
      ['value' => 1, 'label' => 'Up'],
      ['value' => -1, 'label' => 'Down'],
    ];
    $this->createRateWidget('number_up_down', 'Number Up / Down', 'numberupdown', $options, ['node.article']);

    // Reset any static cache.
    drupal_static_reset();

    // Verify the new widget has been added correctly.
    $rate_widget = RateWidgetConfig::load('number_up_down');
    $this->assertEqual($rate_widget->getLabel(), 'Number Up / Down');

    $permissions = [
      'access content',
      'cast rate vote on node of article',
    ];
    $this->users[1] = $this->createUser($permissions);
    $this->users[2] = $this->createUser($permissions);
    $this->users[3] = $this->createUser($permissions);
  }

  /**
   * Tests voting.
   */
  public function testVoting() {
    // Log in as first user and vote +1.
    $this->drupalLogin($this->users[1]);
    $this->drupalGet('node/1');
  }

}
