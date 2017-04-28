<?php

namespace Drupal\ticket\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class RegistrationTypeForm.
 *
 * @package Drupal\ticket\Form
 */
class RegistrationTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $registration_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $registration_type->label(),
      '#description' => $this->t("Label for the Registration type."),
      '#required' => TRUE,
    ];

    $form['trid'] = [
      '#type' => 'machine_name',
      '#default_value' => $registration_type->id(),
      '#maxlength' => EntityTypeInterface::BUNDLE_MAX_LENGTH,
      '#disabled' => $registration_type->isLocked(),
      '#machine_name' => [
        'exists' => ['Drupal\ticket\Entity\RegistrationType', 'load'],
        'source' => ['label'],
      ],
      '#description' => t('A unique machine-readable name for this Registration type. It must only contain lowercase letters, numbers, and underscores. This name will be used for constructing the URL of the %node-add page, in which underscores will be converted into hyphens.', [
        '%node-add' => t('Add content'),
      ]),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $registration_type = $this->entity;
    // Prevent leading and trailing spaces in vocabulary names.
    $registration_type->set('name', trim($registration_type->label()));
    $status = $registration_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Registration type.', [
          '%label' => $registration_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Registration type.', [
          '%label' => $registration_type->label(),
        ]));
    }
    $form_state->setValue('trid', $registration_type->id());
    $form_state->set('trid', $registration_type->id());
    $form_state->setRedirectUrl($registration_type->urlInfo('collection'));
  }

}
