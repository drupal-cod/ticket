<?php

namespace Drupal\ticket\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\ticket\Entity\TicketTypeInterface;

/**
 * Determines access to for Ticket add pages.
 *
 * @ingroup ticket_access
 */
class TicketAddAccessCheck implements AccessInterface {
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
   * Checks access to the node add page for the node type.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The currently logged in account.
   * @param \Drupal\ticket\Entity\TicketTypeInterface $ticket_type
   *   (optional) The ticket type. If not specified, access is allowed if there
   *   exists at least one ticket type for which the user may
   *   create a Ticket.
   *
   * @return string
   *   A \Drupal\Core\Access\AccessInterface constant value.
   */
  public function access(AccountInterface $account, TicketTypeInterface $ticket_type = NULL) {
    $access_control_handler = $this->entityManager->getAccessControlHandler('ticket');
    // If checking whether a node of a particular type may be created.
    if ($account->hasPermission('administer ticket types')) {
      return AccessResult::allowed()->cachePerPermissions();
    }
    if ($ticket_type) {
      return $access_control_handler->createAccess($ticket_type->id(), $account, [], TRUE);
    }
    // If checking whether a node of any type may be created.
    foreach ($this->entityManager->getStorage('$ticket_type')->loadMultiple() as $ticket_type) {
      if (($access = $access_control_handler->createAccess($ticket_type->id(), $account, [], TRUE)) && $access->isAllowed()) {
        return $access;
      }
    }

    // No opinion.
    return AccessResult::neutral();
  }

}
