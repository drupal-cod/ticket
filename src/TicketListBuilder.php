<?php

namespace Drupal\ticket;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Ticket entities.
 *
 * @ingroup ticket
 */
class TicketListBuilder extends EntityListBuilder {

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
    /* @var $entity \Drupal\ticket\Entity\Ticket */
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.ticket.edit_form', [
          'ticket' => $entity->id(),
        ]
      )
    );
    $row['type'] = $entity->getType();
    $row['user'] = $entity->getOwner()->getAccountName();
    return $row + parent::buildRow($entity);
  }

}
