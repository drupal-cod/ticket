<?php

namespace Drupal\ticket\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Ticket type entities.
 */
interface TicketTypeInterface extends ConfigEntityInterface {

  // Add get/set methods for your configuration properties here.
  public function isLocked();
}
