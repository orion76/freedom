<?php

namespace Drupal\dentry\Dentry;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use function t;

abstract class Saldo extends ContentEntityBase implements SaldoInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;

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
   *    Period Type (месячный, недельный, дневной и т.п.)
   *    Period start (дата начала периода)
   *    Account (счет остатков)
   *    Saldo Start
   *    Debet turnovers
   *    Credit turnovers
   *    Saldo End
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {


    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('ID'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Saldo entity.'))
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


    $fields['period_start'] = BaseFieldDefinition::create('timestamp')
      ->setLabel(t('Period start'))
      ->setDescription(t('The time that the entity was created.'));


    $fields['period_type'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Period Type'))
      ->setDescription(t('The ty of the Saldo entity.'))
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

    $fields['account'] = BaseFieldDefinition::create('entity_reference')->setLabel(t('Operation'));

    $fields['saldo_start'] = BaseFieldDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('Saldo start'))
      ->setSetting('unsigned', FALSE);


    $fields['saldo_end'] = BaseFieldDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('Saldo end'))
      ->setSetting('unsigned', FALSE);


    $fields['turnovers_debet'] = BaseFieldDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('Saldo end'))
      ->setSetting('unsigned', TRUE);


    $fields['turnovers_credit'] = BaseFieldDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('Saldo end'))
      ->setSetting('unsigned', TRUE);
    
    return $fields;
  }

}
