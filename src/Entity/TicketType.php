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
 *   bundle_of = "ticket",
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
class TicketType extends ConfigEntityBundleBase implements TicketTypeInterface {

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
  public function getLabel() {
    return $this->label;
  }

  /**
   * {@inheritdoc}
   */
  public function isLocked() {
    if (isset($this->ttid) && !empty($this->ttid)) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

}
