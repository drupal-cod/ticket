<?php

namespace Drupal\ticket\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\ticket\Entity\RegistrationTypeInterface;

/**
 * Determines access to for Registration add pages.
 *
 * @ingroup registration_access
 */
class RegistrationAddAccessCheck implements AccessInterface {
  /**
   * The entity manager.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;

  /**
   * Constructs a EntityCreateAccessCheck object.
   *
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager.
   */
  public function __construct(EntityManagerInterface $entity_manager) {
    $this->entityManager = $entity_manager;
  }

  /**
   * Checks access to the registration add page for the registration type.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The currently logged in account.
   * @param \Drupal\ticket\Entity\RegistrationTypeInterface $registration_type
   *   (optional) The registration type. If not specified, access is allowed
   *   if there exists at least one registration type for which the user may
   *   create a Ticket.
   *
   * @return string
   *   A \Drupal\Core\Access\AccessInterface constant value.
   */
  public function access(AccountInterface $account, RegistrationTypeInterface $registration_type = NULL) {
    $access_control_handler = $this->entityManager->getAccessControlHandler('registration');
    // If checking whether a node of a particular type may be created.
    if ($account->hasPermission('administer registration types')) {
      return AccessResult::allowed()->cachePerPermissions();
    }
    if ($registration_type) {
      return $access_control_handler->createAccess($registration_type->id(), $account, [], TRUE);
    }
    // If checking whether a node of any type may be created.
    foreach ($this->entityManager->getStorage('$registration_type')->loadMultiple() as $registration_type) {
      if (($access = $access_control_handler->createAccess($registration_type->id(), $account, [], TRUE)) && $access->isAllowed()) {
        return $access;
      }
    }

    // No opinion.
    return AccessResult::neutral();
  }

}
