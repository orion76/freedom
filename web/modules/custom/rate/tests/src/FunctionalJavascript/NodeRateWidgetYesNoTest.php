<?php

namespace Drupal\Tests\rate\FunctionalJavascript;

use Drupal\rate\Entity\RateWidgetConfig;

/**
 * Tests for the "Yes / No" widget.
 *
 * @group rate
 */
class NodeRateWidgetYesNoTest extends NodeRateWidgetTestBase {

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    // Create the rate widget.
    $options = [
      ['value' => 1, 'label' => 'Yes'],
      ['value' => -1, 'label' => 'No'],
    ];
    $this->createRateWidget('yesno', 'Yes / No', 'yesno', $options, ['node.article']);

    // Reset any static cache.
    drupal_static_reset();

    // Verify the new widget has been added correctly.
    $rate_widget = RateWidgetConfig::load('yesno');
    $this->assertEqual($rate_widget->getLabel(), 'Yes / No');

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
    // Log in as first user and vote 'Yes'.
    $this->drupalLogin($this->users[1]);
    $this->drupalGet('node/1');
  }

}
