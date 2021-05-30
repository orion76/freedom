<?php

namespace Drupal\freedom_edms\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the Entry entity.
 *
 * @ingroup freedom_edms
 *
 * @ContentEntityType(
 *   id = "edms_dentry",
 *   label = @Translation("Entry"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\freedom_edms\EdmsDentryListBuilder",
 *     "views_data" = "Drupal\freedom_edms\Entity\EdmsDentryViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\freedom_edms\Form\EdmsDentryForm",
 *       "add" = "Drupal\freedom_edms\Form\EdmsDentryForm",
 *       "edit" = "Drupal\freedom_edms\Form\EdmsDentryForm",
 *       "delete" = "Drupal\freedom_edms\Form\EdmsDentryDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\freedom_edms\EdmsDentryHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\freedom_edms\EdmsDentryAccessControlHandler",
 *   },
 *   base_table = "edms_dentry",
 *   translatable = FALSE,
 *   admin_permission = "administer entry entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/edms/edms_dentry/{edms_dentry}",
 *     "add-form" = "/admin/structure/edms/edms_dentry/add",
 *     "edit-form" = "/admin/structure/edms/edms_dentry/{edms_dentry}/edit",
 *     "delete-form" = "/admin/structure/edms/edms_dentry/{edms_dentry}/delete",
 *     "collection" = "/admin/structure/edms/edms_dentry",
 *   },
 *   field_ui_base_route = "edms_dentry.settings"
 * )
 */
class EdmsDentry extends ContentEntityBase implements EdmsDentryInterface {

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
      ->setDescription(t('The name of the Entry entity.'))
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

    $fields['status']->setDescription(t('A boolean indicating whether the Entry is published.'))
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
