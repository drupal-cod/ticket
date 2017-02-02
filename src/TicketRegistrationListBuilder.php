<?php

namespace Drupal\ticket;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Ticket registration entities.
 *
 * @ingroup ticket
 */
class TicketRegistrationListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['name'] = $this->t('Name');
    $header['type'] = $this->t('Ticket Type');
    $header['user'] = $this->t('User');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\ticket\Entity\TicketRegistration */
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.ticket_registration.edit_form', array(
          'ticket_registration' => $entity->id(),
        )
      )
    );
    $row['type'] = $entity->getType();
    $row['user'] = $entity->getOwner()->getAccountName();
    return $row + parent::buildRow($entity);
  }

}
