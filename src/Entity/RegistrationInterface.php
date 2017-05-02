<?php

namespace Drupal\ticket\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Registration entities.
 *
 * @ingroup ticket
 */
interface RegistrationInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Registration type.
   *
   * @return string
   *   The Registration type.
   */
  public function getType();

  /**
   * Gets the Registration name.
   *
   * @return string
   *   Name of the Registration.
   */
  public function getName();

  /**
   * Sets the Registration name.
   *
   * @param string $name
   *   The Registration name.
   *
   * @return \Drupal\ticket\Entity\RegistrationInterface
   *   The called Registration entity.
   */
  public function setName($name);

  /**
   * Gets the Registration creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Registration.
   */
  public function getCreatedTime();

  /**
   * Sets the Registration creation timestamp.
   *
   * @param int $timestamp
   *   The Registration creation timestamp.
   *
   * @return \Drupal\ticket\Entity\RegistrationInterface
   *   The called Registration entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Registration published status indicator.
   *
   * Unpublished Registration are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Registration is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Registration.
   *
   * @param bool $published
   *   TRUE to set this Registration to published,
   *   FALSE to set it to unpublished.
   *
   * @return \Drupal\ticket\Entity\RegistrationInterface
   *   The called Registration entity.
   */
  public function setPublished($published);

}
