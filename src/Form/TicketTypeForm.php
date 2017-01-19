<?php

namespace Drupal\ticket\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TicketTypeForm.
 *
 * @package Drupal\ticket\Form
 */
class TicketTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $ticket_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $ticket_type->label(),
      '#description' => $this->t("Label for the Ticket type."),
      '#required' => TRUE,
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $ticket_type = $this->entity;
    $status = $ticket_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Ticket type.', [
          '%label' => $ticket_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Ticket type.', [
          '%label' => $ticket_type->label(),
        ]));
    }
    $form_state->setValue('ttid', $ticket_type->id());
    $form_state->set('ttid', $ticket_type->id());
    $form_state->setRedirectUrl($ticket_type->urlInfo('collection'));
  }

}
