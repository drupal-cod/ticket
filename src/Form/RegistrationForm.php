<?php

namespace Drupal\ticket\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Registration edit forms.
 *
 * @ingroup ticket
 */
class RegistrationForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $registration = $this->entity;
    $form = parent::form($form, $form_state);
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $registration = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Registration.', [
          '%label' => $registration->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Registration.', [
          '%label' => $registration->label(),
        ]));
    }
    $form_state->setValue('registrationId', $registration->id());
    $form_state->set('registrationId', $registration->id());
    $form_state->setRedirect('entity.registration.canonical', ['registration' => $registration->id()]);
  }

}
