<?php

namespace Drupal\ticket\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Ticket registration edit forms.
 *
 * @ingroup ticket
 */
class TicketRegistrationForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\ticket\Entity\TicketRegistration */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Ticket registration.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Ticket registration.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setValue('trid', $entity->id());
    $form_state->set('trid', $entity->id());
    $form_state->setRedirect('entity.ticket_registration.canonical', ['ticket_registration' => $entity->id()]);
  }

}
