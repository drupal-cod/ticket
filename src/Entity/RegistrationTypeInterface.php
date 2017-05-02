<?php

namespace Drupal\ticket\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Registration type entities.
 */
interface RegistrationTypeInterface extends ConfigEntityInterface {

  /**
   * {@inheritdoc}
   */
  public function isLocked();

}
