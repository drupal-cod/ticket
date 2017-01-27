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

    $form['ttid'] = array(
        '#type' => 'machine_name',
        '#default_value' => $ticket_type->id(),
        '#maxlength' => EntityTypeInterface::BUNDLE_MAX_LENGTH,
        '#disabled' => $ticket_type->isLocked(),
        '#machine_name' => array(
            'exists' => ['Drupal\ticket\Entity\TicketType', 'load'],
            'source' => array('name'),
        ),
        '#description' => t('A unique machine-readable name for this ticket type. It must only contain lowercase letters, numbers, and underscores. This name will be used for constructing the URL of the %node-add page, in which underscores will be converted into hyphens.', array(
            '%node-add' => t('Add content'),
        )),
    );

    $form['description'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#default_value' => $ticket_type->getDescription(),
    );

    $form['quantity'] = array(
      '#type' => 'number',
      '#title' => $this->t('Total Quantity'),
      '#description' => t('The total number of tickets available. Leave blank for no limit.'),
      '#default_value' => $ticket_type->getQuantity(),
    );

    $form['order_min'] = array(
        '#type' => 'number',
        '#required' => TRUE,
        '#title' => $this->t('Min per order'),
        '#description' => t('The minimum number of tickets per order.'),
        '#default_value' => $ticket_type->getOrderMin(),
    );

    $form['order_max'] = array(
        '#type' => 'number',
        '#title' => $this->t('Max per order'),
        '#description' => t('The maxiumum number of tickets per order. Leave blank for no maximum.'),
        '#default_value' => $ticket_type->getOrderMax(),
    );

    $form['start_date'] = array(
      '#type' => 'datetime',
      '#title' => $this->t('Registration Start'),
      '#date_year_range' => '0:20',
      '#description' => t('The date and time when this ticket type will be available to order.'),
      '#default_value' => $ticket_type->getStartDate(),
    );

    $form['end_date'] = array(
        '#type' => 'datetime',
        '#title' => $this->t('Registration End'),
        '#date_year_range' => '0:20',
        '#description' => t('The date and time when this ticket type will stop being available to order.'),
        '#default_value' => $ticket_type->getEndDate(),
    );

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
