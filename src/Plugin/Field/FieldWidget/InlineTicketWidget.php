<?php

namespace Drupal\ticket\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'entity_reference ticket' widget.
 *
 * We hide add / remove buttons when translating to avoid accidental loss of
 * data because these actions effect all languages.
 *
 * @FieldWidget(
 *   id = "entity_reference_ticket",
 *   label = @Translation("Tickets"),
 *   description = @Translation("A ticket inline form widget."),
 *   field_types = {
 *     "entity_reference_revisions"
 *   }
 * )
 */
class InlineTicketWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'title' => t('Ticket'),
      'title_plural' => t('Tickets'),
      'edit_mode' => 'open',
      'add_mode' => 'dropdown',
      'form_display_mode' => 'default',
      'default_ticket_type' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    $elements['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Ticket Title'),
      '#description' => $this->t('Label to appear as title on the button as "Add new [title]", this label is translatable'),
      '#default_value' => $this->getSetting('title'),
      '#required' => TRUE,
    ];

    $elements['title_plural'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Plural Ticket Title'),
      '#description' => $this->t('Title in its plural form.'),
      '#default_value' => $this->getSetting('title_plural'),
      '#required' => TRUE,
    ];

    $elements['edit_mode'] = [
      '#type' => 'select',
      '#title' => $this->t('Edit mode'),
      '#description' => $this->t('The mode the ticket is in by default. Preview will render the ticket in the preview view mode.'),
      '#options' => [
        'open' => $this->t('Open'),
        'closed' => $this->t('Closed'),
        'preview' => $this->t('Preview'),
      ],
      '#default_value' => $this->getSetting('edit_mode'),
      '#required' => TRUE,
    ];

    $elements['add_mode'] = [
      '#type' => 'select',
      '#title' => $this->t('Add mode'),
      '#description' => $this->t('The way to add new tickets.'),
      '#options' => [
        'select' => $this->t('Select list'),
        'button' => $this->t('Buttons'),
        'dropdown' => $this->t('Dropdown button'),
      ],
      '#default_value' => $this->getSetting('add_mode'),
      '#required' => TRUE,
    ];

    $elements['form_display_mode'] = [
      '#type' => 'select',
      '#options' => \Drupal::service('entity_display.repository')->getFormModeOptions($this->getFieldSetting('target_type')),
      '#description' => $this->t('The form display mode to use when rendering the ticket form.'),
      '#title' => $this->t('Form display mode'),
      '#default_value' => $this->getSetting('form_display_mode'),
      '#required' => TRUE,
    ];

    $options = [];
    foreach ($this->getAllowedTypes() as $key => $bundle) {
      $options[$key] = $bundle['label'];
    }

    $elements['default_ticket_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Default ticket type'),
      '#empty_value' => '_none',
      '#default_value' => $this->getDefaultParagraphTypeMachineName(),
      '#options' => $options,
      '#description' => $this->t('When creating a new host entity, a ticket of this type is added.'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   *
   * @see \Drupal\content_translation\Controller\ContentTranslationController::prepareTranslation()
   *   Uses a similar approach to populate a new translation.
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    $element['value'] += [
      '#suffix' => '<div class="field-example-colorpicker"></div>',
      '#attributes' => ['class' => ['edit-field-example-colorpicker']],
    ];

    return $element;
  }

}
