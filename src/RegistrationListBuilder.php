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
class RegistrationListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['name'] = $this->t('Name');
    $header['type'] = $this->t('Registration Type');
    $header['user'] = $this->t('User');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\ticket\Entity\Registration */
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.registration.edit_form', [
          'registration' => $entity->id(),
        ]
      )
    );
    $row['type'] = $entity->getType();
    $row['user'] = $entity->getOwner()->getAccountName();
    return $row + parent::buildRow($entity);
  }

}
