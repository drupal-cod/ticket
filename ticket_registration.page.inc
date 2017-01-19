<?php

/**
 * @file
 * Contains ticket_registration.page.inc.
 *
 * Page callback for Ticket registration entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Ticket registration templates.
 *
 * Default template: ticket_registration.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_ticket_registration(array &$variables) {
  // Fetch TicketRegistration Entity Object.
  $ticket_registration = $variables['elements']['#ticket_registration'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
