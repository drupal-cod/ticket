<?php

namespace Drupal\ticket\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Ticket entities.
 *
 * @ingroup ticket
 */
interface TicketInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Ticket type.
   *
   * @return string
   *   The Ticket type.
   */
  public function getType();

  /**
   * Gets the Ticket name.
   *
   * @return string
   *   Name of the Ticket.
   */
  public function getName();

  /**
   * Sets the Ticket name.
   *
   * @param string $name
   *   The Ticket name.
   *
   * @return \Drupal\ticket\Entity\TicketInterface
   *   The called Ticket entity.
   */
  public function setName($name);

  /**
   * Gets the Ticket creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Ticket.
   */
  public function getCreatedTime();

  /**
   * Sets the Ticket creation timestamp.
   *
   * @param int $timestamp
   *   The Ticket creation timestamp.
   *
   * @return \Drupal\ticket\Entity\TicketInterface
   *   The called Ticket entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Ticket published status indicator.
   *
   * Unpublished Ticket are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Ticket is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Ticket.
   *
   * @param bool $published
   *   TRUE to set this Ticket to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\ticket\Entity\TicketInterface
   *   The called Ticket entity.
   */
  public function setPublished($published);

}
