<?php

namespace Drupal\ticket;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Ticket entity.
 *
 * @see \Drupal\ticket\Entity\Ticket.
 */
class TicketAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\ticket\Entity\TicketInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished ticket entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published ticket entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit ticket entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete ticket entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add ticket entities');
  }

}
