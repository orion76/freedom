<?php

namespace Drupal\developer\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the developer module.
 */
class DeveloperControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "developer DeveloperController's controller functionality",
      'description' => 'Test Unit for module developer and controller DeveloperController.',
      'group' => 'Other',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests developer functionality.
   */
  public function testDeveloperController() {
    // Check that the basic functions of module developer.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
