<?php

/**
 * @file
 * Contains \Drupal\Tests\block\Unit\BlockRepositoryTest.
 */

namespace Drupal\Tests\block\Unit;

use Drupal\block\BlockRepository;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContextAwarePluginInterface;
use Drupal\Tests\UnitTestCase;

/**
 * @coversDefaultClass \Drupal\block\BlockRepository
 * @group block
 */
class DentryRepositoryTest extends UnitTestCase {


  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
  }


  public function testGetVisibleBlocksPerRegion(array $blocks_config, array $expected_blocks) {

  }
}
