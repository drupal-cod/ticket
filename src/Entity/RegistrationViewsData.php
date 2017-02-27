<?php

namespace Drupal\ticket\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Registration entities.
 */
class RegistrationViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['registration']['table']['base'] = array(
      'field' => 'registration_id',
      'title' => $this->t('Registration'),
      'help' => $this->t('The Registration ID.'),
    );

    return $data;
  }

}
