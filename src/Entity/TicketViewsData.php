<?php

namespace Drupal\ticket\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Ticket entities.
 */
class TicketViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['ticket']['table']['base'] = [
      'field' => 'ticketId',
      'title' => $this->t('Ticket'),
      'help' => $this->t('The Ticket ID.'),
    ];

    return $data;
  }

}
