<?php

namespace Drupal\ticket\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Ticket registration entity.
 *
 * @ingroup ticket
 *
 * @ContentEntityType(
 *   id = "ticket_registration",
 *   label = @Translation("Ticket registration"),
 *   bundle_label = @Translation("Ticket type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ticket\TicketRegistrationListBuilder",
 *     "views_data" = "Drupal\ticket\Entity\TicketRegistrationViewsData",
 *     "translation" = "Drupal\ticket\TicketRegistrationTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\ticket\Form\TicketRegistrationForm",
 *       "add" = "Drupal\ticket\Form\TicketRegistrationForm",
 *       "edit" = "Drupal\ticket\Form\TicketRegistrationForm",
 *       "delete" = "Drupal\ticket\Form\TicketRegistrationDeleteForm",
 *     },
 *     "access" = "Drupal\ticket\TicketRegistrationAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\ticket\TicketRegistrationHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "ticket_registration",
 *   data_table = "ticket_registration_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer ticket registration entities",
 *   entity_keys = {
 *     "id" = "trid",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "uid",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *     "bundle" = "ticket_type",
 *   },
 *   bundle_entity_type = "ticket_type",
 *   links = {
 *     "canonical" = "/ticket/registration/{ticket_registration}",
 *     "edit-form" = "/ticket/registration/{ticket_registration}/edit",
 *     "delete-form" = "/ticket/registration/{ticket_registration}/delete",
 *     "collection" = "/ticket/registration",
 *   },
 *   field_ui_base_route = "entity.ticket_type.edit_form"
 * )
 */
class TicketRegistration extends ContentEntityBase implements TicketRegistrationInterface {

  use EntityChangedTrait;

  protected $uid;

  protected $trid;

  protected $ticketType;

  /**
   * {@inheritdoc}
   */
  public function getTicketType() {
    return $this->ticketType;
  }

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'uid' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getType() {
    return $this->bundle();
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
   */
  public function getOwner() {
    return $this->get('uid')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('uid')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('uid', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('uid', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? NODE_PUBLISHED : NODE_NOT_PUBLISHED);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Ticket registration entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Ticket registration entity.'))
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Ticket registration is published.'))
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
