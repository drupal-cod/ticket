<?php

namespace Drupal\ticket\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Ticket registration entities.
 */
class TicketRegistrationViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['ticket_registration']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Ticket registration'),
      'help' => $this->t('The Ticket registration ID.'),
    );

    return $data;
  }

}
