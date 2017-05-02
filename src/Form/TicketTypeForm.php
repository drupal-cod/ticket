<?php

namespace Drupal\ticket\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityTypeInterface;
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

    $form['ttid'] = [
      '#type' => 'machine_name',
      '#default_value' => $ticket_type->id(),
      '#maxlength' => EntityTypeInterface::BUNDLE_MAX_LENGTH,
      '#disabled' => $ticket_type->isLocked(),
      '#machine_name' => [
        'exists' => ['Drupal\ticket\Entity\TicketType', 'load'],
        'source' => ['label'],
      ],
      '#description' => t('A unique machine-readable name for this ticket type. It must only contain lowercase letters, numbers, and underscores. This name will be used for constructing the URL of the %node-add page, in which underscores will be converted into hyphens.', [
        '%node-add' => t('Add content'),
      ]),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $ticket_type = $this->entity;
    // Prevent leading and trailing spaces in vocabulary names.
    $ticket_type->set('name', trim($ticket_type->label()));
    $status = $ticket_type->save();

    switch ($status) {
      case SAVED_NEW:
        ticket_type_add_description($ticket_type);
        ticket_type_add_registration($ticket_type);
        ticket_type_add_quantity($ticket_type);
        ticket_type_add_dates($ticket_type);
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
