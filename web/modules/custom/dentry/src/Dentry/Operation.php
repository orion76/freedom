<?php

namespace Drupal\dentry\Dentry;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use function t;

abstract class Operation extends ContentEntityBase implements OperationInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;

  private $entries = [];

  public function getEntries() {
    return $this->entries;
  }


  public function addEntry($entry) {
    $this->entries[] = $entry;
    return $this;
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
   * Fields
   *    ID
   *    Name
   *    Created
   *    Value
   *    DocumentBase
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {


    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('ID'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Operation entity.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);


    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['document'] = BaseFieldDefinition::create('entity_reference')->setLabel(t('Document'));

    $fields['value'] = self::valueFieldDefinition($entity_type);
    return $fields;
  }

  protected static function valueFieldDefinition(EntityTypeInterface $entity_type) {
    return BaseFieldDefinition::create('integer')
      ->setLabel(t('Value'))
      ->setDescription(t('The entry value.'))
      ->setSetting('unsigned', TRUE);
  }

}
