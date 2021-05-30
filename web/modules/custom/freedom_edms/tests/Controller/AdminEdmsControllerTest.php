<?php

namespace Drupal\freedom_edms\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the freedom_edms module.
 */
class AdminEdmsControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "freedom_edms AdminEdmsController's controller functionality",
      'description' => 'Test Unit for module freedom_edms and controller AdminEdmsController.',
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
   * Tests freedom_edms functionality.
   */
  public function testAdminEdmsController() {
    // Check that the basic functions of module freedom_edms.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
