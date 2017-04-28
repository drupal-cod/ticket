<?php

namespace Drupal\ticket\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Ticket entity.
 *
 * @ingroup ticket
 *
 * @ContentEntityType(
 *   id = "ticket",
 *   label = @Translation("Ticket"),
 *   bundle_label = @Translation("Ticket type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ticket\TicketListBuilder",
 *     "views_data" = "Drupal\ticket\Entity\TicketViewsData",
 *     "translation" = "Drupal\ticket\TicketTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\ticket\Form\TicketForm",
 *       "add" = "Drupal\ticket\Form\TicketForm",
 *       "edit" = "Drupal\ticket\Form\TicketForm",
 *       "delete" = "Drupal\ticket\Form\TicketDeleteForm",
 *     },
 *     "access" = "Drupal\ticket\TicketAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\ticket\TicketHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "ticket",
 *   data_table = "ticket_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer ticket entities",
 *   entity_keys = {
 *     "id" = "ticketId",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "uid",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *     "bundle" = "ticket_type",
 *   },
 *   bundle_entity_type = "ticket_type",
 *   links = {
 *     "canonical" = "/ticket/tickets/{ticket}",
 *     "edit-form" = "/ticket/tickets/{ticket}/edit",
 *     "delete-form" = "/ticket/tickets/{ticket}/delete",
 *     "collection" = "/ticket/tickets",
 *   },
 *   field_ui_base_route = "entity.ticket_type.edit_form"
 * )
 */
class Ticket extends ContentEntityBase implements TicketInterface {

  use EntityChangedTrait;

  protected $uid;

  protected $id;

  protected $ticketId;

  protected $ticketType;

  /**
   * {@inheritdoc}
   */
  public function getTicketId() {
    return $this->id;
  }

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
    $values += [
      'uid' => \Drupal::currentUser()->id(),
    ];
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
  public function setRegistrationType($registration) {
    $this->set('field_ticket_registration_type', $registration);
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
      ->setDescription(t('The user ID of author of the Ticket entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Ticket entity.'))
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
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Ticket is published.'))
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
