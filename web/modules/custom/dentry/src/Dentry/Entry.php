<?php

namespace Drupal\dentry\Dentry;

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use function t;
use function ucfirst;


abstract class Entry extends ContentEntityBase implements EntryInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;

  /** @var OperationInterface */
  private $operation;

  public function __set($name, $value) {
    $definitions = $this->getFieldDefinitions();
    $def = $definitions['credit_subconto_1'];
    $n = 0;
    if (in_array($name, ['debet', 'credit'])) {
      $this->setSubcontoTargetType($name, $value);
    }
    parent::__set($name, $value);

  }

  private function setSubcontoTargetType($account_type, ConfigEntityInterface $account) {
    $settings = $account->get('subconto');

    foreach (self::getSubcontoFieldNames($account_type) as $key => $field_name) {
      $settings_name = "subconto_{$key}";
      $target_type = NestedArray::getValue($settings, [$settings_name, 'entity_type']);

      $this->getFieldDefinition($field_name)->setSetting('target_type', $target_type);
    }

  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   * Fields:
   *    ID
   *    Name
   *    Description
   *    Created
   *    Operation ID
   *    Value
   *    Description
   *    Debet account
   *    Subconto 1
   *    Subconto 2
   *    Subconto 3
   *    Subconto 4
   *    Subconto 5
   *    Credit account
   *    Subconto 1
   *    Subconto 2
   *    Subconto 3
   *    Subconto 4
   *    Subconto 5
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('ID'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Entry entity.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['description'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Description'))
      ->setDescription(t('The Entry description.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);


    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['operation'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Operation'))
      ->setSetting('target_type', $entity_type->get('reference_types')['operation']);

    $fields['value'] = self::valueFieldDefinition($entity_type);

    foreach (['debet', 'credit'] as $account_type) {
      $fields += self::addAccountFieldDefinitions($account_type, $entity_type);
    }

    return $fields;
  }

  protected static function valueFieldDefinition(EntityTypeInterface $entity_type) {
    return BaseFieldDefinition::create('integer')
      ->setLabel(t('Value'))
      ->setDescription(t('The entry value.'))
      ->setSetting('unsigned', TRUE);
  }

  protected static function addAccountFieldDefinitions($account_type, EntityTypeInterface $entity_type) {
    $account_key = "{$account_type}";
    $account_label = ucfirst($account_type);

    $fields[$account_key] = BaseFieldDefinition::create('entity_reference')
      ->setSetting('target_type', $entity_type->get('reference_types')['point'])
      ->setLabel(t($account_label));

    foreach (self::getSubcontoFieldNames($account_type) as $key => $field_name) {
      $label = "{$account_label} Subconto {$key}";
      $fields[$field_name] = BaseFieldDefinition::create('dentry_subconto_reference')->setLabel(t($label));
    }


    return $fields;
  }

  protected static function getSubcontoFieldNames($account_type) {
    $names = [];
    for ($i = 1; $i <= 5; $i++) {
      $names[$i] = "{$account_type}_subconto_{$i}";
    }
    return $names;
  }


  public function setOperation(OperationInterface $operation) {
    $this->operation = $operation;
  }

  public function getOperation() {
    return $this->operation;
  }
}
