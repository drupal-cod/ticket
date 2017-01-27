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
 *     "canonical" = "/ticket/type/{ticket_type}",
 *     "add-form" = "/ticket/type/add",
 *     "edit-form" = "/ticket/type/{ticket_type}/edit",
 *     "delete-form" = "/ticket/type/{ticket_type}/delete",
 *     "collection" = "/ticket/type"
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
   * Description of the Ticket type.
   *
   * @var string
   */
  protected $description;

  /**
   * Quantity of Tickets for this Ticket type.
   *
   * @var integer
   */
  protected $quantity;

  /**
   * Registration start date for this Ticket type.
   *
   * @var integer
   */
  protected $start_date;

  /**
   * Registration end date for this Ticket type.
   *
   * @var integer
   */
  protected $end_date;

  /**
   * {@inheritdoc}
   */
  public function id() {
    return $this->ttid;
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * {@inheritdoc}
   */
  public function getQuantity() {
    return $this->quantity;
  }

  /**
   * {@inheritdoc}
   */
  public function getStartDate() {
    return $this->start_date;
  }

  /**
   * {@inheritdoc}
   */
  public function getEndDate() {
    return $this->end_date;
  }

  /**
   * {@inheritdoc}
   */
  public function isLocked() {
    if (isset($this->ttid) && !empty($this->ttid)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }
}