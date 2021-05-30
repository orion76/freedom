<?php

namespace Drupal\freedom_edms\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the Saldo entity.
 *
 * @ingroup freedom_edms
 *
 * @ContentEntityType(
 *   id = "edms_dentry_saldo",
 *   label = @Translation("Saldo"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\freedom_edms\EdmsDentrySaldoListBuilder",
 *     "views_data" = "Drupal\freedom_edms\Entity\EdmsDentrySaldoViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\freedom_edms\Form\EdmsDentrySaldoForm",
 *       "add" = "Drupal\freedom_edms\Form\EdmsDentrySaldoForm",
 *       "edit" = "Drupal\freedom_edms\Form\EdmsDentrySaldoForm",
 *       "delete" = "Drupal\freedom_edms\Form\EdmsDentrySaldoDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\freedom_edms\EdmsDentrySaldoHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\freedom_edms\EdmsDentrySaldoAccessControlHandler",
 *   },
 *   base_table = "edms_dentry_saldo",
 *   translatable = FALSE,
 *   admin_permission = "administer saldo entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/edms/edms_dentry_saldo/{edms_dentry_saldo}",
 *     "add-form" = "/admin/structure/edms/edms_dentry_saldo/add",
 *     "edit-form" = "/admin/structure/edms/edms_dentry_saldo/{edms_dentry_saldo}/edit",
 *     "delete-form" = "/admin/structure/edms/edms_dentry_saldo/{edms_dentry_saldo}/delete",
 *     "collection" = "/admin/structure/edms/edms_dentry_saldo",
 *   },
 *   field_ui_base_route = "edms_dentry_saldo.settings"
 * )
 */
class EdmsDentrySaldo extends ContentEntityBase implements EdmsDentrySaldoInterface {

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
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Add the published field.
    $fields += static::publishedBaseFieldDefinitions($entity_type);

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

    $fields['status']->setDescription(t('A boolean indicating whether the Saldo is published.'))
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
