<?php

namespace Drupal\Tests\dentry\Kernel;

use Drupal\Core\Config\Entity\ConfigEntityStorageInterface;
use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\dentry_test\Entity\EntryTest;
use Drupal\KernelTests\KernelTestBase;

/**
 * Tests the storage of blocks.
 *
 * @group dentry
 */
class DentryStorageUnitTest extends KernelTestBase {

  /**
   * Modules to install.
   *
   * @var array
   */
  public static $modules = [
    'dentry',
    'dentry_test',
    'system',
  ];

  /**
   * The block storage.
   *
   * @var ContentEntityStorageInterface
   */
  protected $entryStorage;

  /**
   * The block storage.
   *
   * @var ConfigEntityStorageInterface
   */
  protected $pointStorage;

  /**
   * The block storage.
   *
   * @var EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  protected function setUp() {
    parent::setUp();

    $this->installEntitySchema('entry_test');
    $this->installEntitySchema('point_test');
    
    $this->entityTypeManager = $this->container->get('entity_type.manager');
    $this->entryStorage = $this->entityTypeManager->getStorage('entry_test');
    $this->pointStorage = $this->entityTypeManager->getStorage('point_test');

    $n = 0;
  }

  /**
   * Tests CRUD operations.
   */
  public function testEntryCreate() {

    $entity = $this->entryStorage->create($this->getEntryValues());
    $this->assertInstanceOf(EntryTest::class, $entity);
//    $entity->getFieldDefinitions();
    $entity->save();
    $n = 0;
  }

  public function ___testPointCreate() {
    $values = $this->getData('point_debet');
    $entity = $this->pointStorage->create($values);

    $entity->get('code');
    $this->assertEqual($entity->get('code'), $values['code']);
    $n = 0;
  }

  private function getEntryValues(){
    return [
      'debet'=>$this->pointStorage->create($this->getData('point_debet')),
      'credit'=>$this->pointStorage->create($this->getData('point_credit')),
    ];
  }

  private function getData($name) {
    $data = [
      'point_debet' => [
        'id'=>'point_debet',
        'code' => '1.1',
        'label' => 'Debet Test account',
        'account_type' => 'active',
        'account_item' => 'off_balance',
        'subconto' => [
          'subconto_1' => ['entity_type' => 'entity_type_1', 'bundle' => 'bundle_1'],
          'subconto_2' => ['entity_type' => 'entity_type_2', 'bundle' => 'bundle_2'],
          'subconto_3' => ['entity_type' => 'entity_type_3', 'bundle' => 'bundle_3'],
          'subconto_4' => ['entity_type' => 'entity_type_4', 'bundle' => 'bundle_4'],
          'subconto_5' => ['entity_type' => 'entity_type_5', 'bundle' => 'bundle_5'],
        ],
      ],
      'point_credit' => [
        'id'=>'point_credit',
        'code' => '1.1',
        'label' => 'Credit Test account',
        'account_type' => 'active',
        'account_item' => 'off_balance',
        'subconto' => [
          'subconto_1' => ['entity_type' => 'entity_type_1', 'bundle' => 'bundle_1'],
          'subconto_2' => ['entity_type' => 'entity_type_2', 'bundle' => 'bundle_2'],
          'subconto_3' => ['entity_type' => 'entity_type_3', 'bundle' => 'bundle_3'],
          'subconto_4' => ['entity_type' => 'entity_type_4', 'bundle' => 'bundle_4'],
          'subconto_5' => ['entity_type' => 'entity_type_5', 'bundle' => 'bundle_5'],
        ],
      ],
    ];


    return $data[$name];
  }

}
