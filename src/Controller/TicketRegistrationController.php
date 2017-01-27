<?php

namespace Drupal\ticket\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\ticket\Entity\TicketTypeInterface;

/**
 * Returns responses for Ticket registration routes.
 */
class TicketRegistrationController extends ControllerBase implements ContainerInjectionInterface {
  /**
   * The renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;


  /**
   * Displays add ticket registration links for available ticket types.
   *
   * Redirects to ticket_registration/add/[ticket_type] if only one ticket type is available.
   *
   * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
   *   A render array for a list of the ticket types that can be added; however,
   *   if there is only one ticket type defined for the site, the function
   *   will return a RedirectResponse to the ticket registration add page for that one ticket
   *   type.
   */
  public function addPage() {
    $build = [
        '#theme' => 'ticket_registration_add_list',
        '#cache' => [
            'tags' => $this->entityManager()->getDefinition('ticket_type')->getListCacheTags(),
        ],
    ];

    $ticket = array();

    // Only use node types the user has access to.
    foreach ($this->entityManager()->getStorage('ticket_type')->loadMultiple() as $ticket_type) {
      $access = $this->entityManager()->getAccessControlHandler('ticket_type')->createAccess($ticket_type->id(), NULL, [], TRUE);
      if ($access->isAllowed()) {
        $ticket[$ticket_type->id()] = $ticket_type;
      }
      //$this->renderer->addCacheableDependency($build, $access);
    }

    // Bypass the ticket_registration/add listing if only one content type is available.
    if (count($ticket) == 1) {
      $ticket_type = array_shift($ticket);
      return $this->redirect('ticket_registration.add', array('ticket_type' => $ticket_type->id()));
    }

    $build['#content'] = $ticket;

    return $build;
  }

  /**
   * Provides the ticket registration submission form.
   *
   * @param \Drupal\ticket\Entity\TicketTypeInterface $ticket_type
   *   The ticket type entity for the ticket registration.
   *
   * @return array
   *   A ticket registration submission form.
   */
  public function add(TicketTypeInterface $ticket_type) {
    $ticket = $this->entityManager()->getStorage('ticket_registration')->create(array(
        'ticket_type' => $ticket_type->id(),
    ));

    $form = $this->entityFormBuilder()->getForm($ticket);

    return $form;
  }

  /**
   * The _title_callback for the ticket_registration.add route.
   *
   * @param \Drupal\ticket\Entity\TicketTypeInterface $ticket_type
   *   The current ticket registration.
   *
   * @return string
   *   The ticket registration title.
   */
  public function addPageTitle(TicketTypeInterface $ticket_type) {
    return $this->t('Create @name', array('@name' => $ticket_type->label()));
  }
}