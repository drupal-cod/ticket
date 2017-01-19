<?php

namespace Drupal\ticket\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Ticket registration type entity.
 *
 * @ConfigEntityType(
 *   id = "ticket_registration_type",
 *   label = @Translation("Ticket registration type"),
 *   handlers = {
 *     "list_builder" = "Drupal\ticket\TicketRegistrationTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\ticket\Form\TicketRegistrationTypeForm",
 *       "edit" = "Drupal\ticket\Form\TicketRegistrationTypeForm",
 *       "delete" = "Drupal\ticket\Form\TicketRegistrationTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\ticket\TicketRegistrationTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "ticket_registration_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "ticket_registration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/ticket/ticket_registration_type/{ticket_registration_type}",
 *     "add-form" = "/admin/ticket/ticket_registration_type/add",
 *     "edit-form" = "/admin/ticket/ticket_registration_type/{ticket_registration_type}/edit",
 *     "delete-form" = "/admin/ticket/ticket_registration_type/{ticket_registration_type}/delete",
 *     "collection" = "/admin/ticket/ticket_registration_type"
 *   }
 * )
 */
class TicketRegistrationType extends ConfigEntityBundleBase implements TicketRegistrationTypeInterface {

  /**
   * The Ticket registration type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Ticket registration type label.
   *
   * @var string
   */
  protected $label;

}
