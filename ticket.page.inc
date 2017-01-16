<?php

/**
 * @file
 * Contains ticket.page.inc.
 *
 * Page callback for Ticket entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Ticket templates.
 *
 * Default template: ticket.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_ticket(array &$variables) {
  // Fetch Ticket Entity Object.
  $ticket = $variables['elements']['#ticket'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
