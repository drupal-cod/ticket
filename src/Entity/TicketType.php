<?php

namespace Drupal\ticket\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Ticket type entity.
 *
 * @ConfigEntityType(
 *   id = "ticket_type",
 *   label = @Translation("Ticket type"),
 *   handlers = {
 *     "list_builder" = "Drupal\ticket\TicketTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\ticket\Form\TicketTypeForm",
 *       "edit" = "Drupal\ticket\Form\TicketTypeForm",
 *       "delete" = "Drupal\ticket\Form\TicketTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\ticket\TicketTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "ticket_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "ticket_registration",
 *   entity_keys = {
 *     "id" = "ttid",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/ticket/ticket_type/{ticket_type}",
 *     "add-form" = "/admin/ticket/ticket_type/add",
 *     "edit-form" = "/admin/ticket/ticket_type/{ticket_type}/edit",
 *     "delete-form" = "/admin/ticket/ticket_type/{ticket_type}/delete",
 *     "collection" = "/admin/ticket/ticket_type"
 *   }
 * )
 */
class TicketType extends ConfigEntityBundleBase implements TicketTypeInterface
{

  /**
   * The Ticket type ID.
   *
   * @var string
   */
  protected $ttid;

  /**
   * The Ticket type label.
   *
   * @var string
   */
  protected $label;

  /**
   * {@inheritdoc}
   */
  public function id()
  {
    return $this->ttid;
  }
}