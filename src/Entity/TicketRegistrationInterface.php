<?php

namespace Drupal\ticket\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Ticket registration entities.
 *
 * @ingroup ticket
 */
interface TicketRegistrationInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Ticket registration type.
   *
   * @return string
   *   The Ticket registration type.
   */
  public function getType();

  /**
   * Gets the Ticket registration name.
   *
   * @return string
   *   Name of the Ticket registration.
   */
  public function getName();

  /**
   * Sets the Ticket registration name.
   *
   * @param string $name
   *   The Ticket registration name.
   *
   * @return \Drupal\ticket\Entity\TicketRegistrationInterface
   *   The called Ticket registration entity.
   */
  public function setName($name);

  /**
   * Gets the Ticket registration creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Ticket registration.
   */
  public function getCreatedTime();

  /**
   * Sets the Ticket registration creation timestamp.
   *
   * @param int $timestamp
   *   The Ticket registration creation timestamp.
   *
   * @return \Drupal\ticket\Entity\TicketRegistrationInterface
   *   The called Ticket registration entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Ticket registration published status indicator.
   *
   * Unpublished Ticket registration are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Ticket registration is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Ticket registration.
   *
   * @param bool $published
   *   TRUE to set this Ticket registration to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\ticket\Entity\TicketRegistrationInterface
   *   The called Ticket registration entity.
   */
  public function setPublished($published);

}
