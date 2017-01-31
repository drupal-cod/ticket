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
  public function form(array $form, FormStateInterface $form_state) {
    $ticket = $this->entity;
    $form = parent::form($form, $form_state);
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $ticket = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Ticket registration.', [
          '%label' => $ticket->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Ticket registration.', [
          '%label' => $ticket->label(),
        ]));
    }
    $form_state->setValue('trid', $ticket->id());
    $form_state->set('trid', $ticket->id());
    $form_state->setRedirect('entity.ticket_registration.canonical', ['ticket_registration' => $ticket->id()]);
  }

}
