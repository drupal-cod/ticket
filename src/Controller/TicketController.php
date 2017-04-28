<?php

namespace Drupal\ticket\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\ticket\Entity\TicketTypeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Ticket routes.
 */
class TicketController extends ControllerBase implements ContainerInjectionInterface {
  /**
   * The renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * Constructs a NodeController object.
   *
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer service.
   */
  public function __construct(RendererInterface $renderer) {
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
        $container->get('renderer')
    );
  }

  /**
   * Displays add ticket links for available ticket types.
   *
   * Redirects to ticket/add/[ticket_type] if only one ticket type is available.
   *
   * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
   *   A render array for a list of the ticket types that can be added; however,
   *   if there is only one ticket type defined for the site, the function
   *   will return a RedirectResponse to the Ticket add page for that one ticket
   *   type.
   */
  public function addPage() {
    $build = [
      '#theme' => 'ticket_add_list',
      '#cache' => [
        'tags' => $this->entityManager()->getDefinition('ticket_type')->getListCacheTags(),
      ],
    ];

    $ticket = [];

    // Only use node types the user has access to.
    foreach ($this->entityManager()->getStorage('ticket_type')->loadMultiple() as $ticket_type) {
      $access = $this->entityManager()->getAccessControlHandler('ticket_type')->createAccess($ticket_type->id(), NULL, [], TRUE);
      if ($access->isAllowed()) {
        $ticket[$ticket_type->id()] = $ticket_type;
      }
    }

    // Bypass the ticket/add listing if only one content type is available.
    if (count($ticket) == 1) {
      $ticket_type = array_shift($ticket);
      return $this->redirect('ticket.add', ['ticket_type' => $ticket_type->id()]);
    }

    $build['#content'] = $ticket;

    return $build;
  }

  /**
   * Provides the ticket submission form.
   *
   * @param \Drupal\ticket\Entity\TicketTypeInterface $ticket_type
   *   The ticket type entity for the ticket.
   *
   * @return array
   *   A ticket submission form.
   */
  public function add(TicketTypeInterface $ticket_type) {
    $ticket = $this->entityManager()->getStorage('ticket')->create(['ticket_type' => $ticket_type->id()]);

    $form = $this->entityFormBuilder()->getForm($ticket);

    return $form;
  }

  /**
   * The _title_callback for the ticket.add route.
   *
   * @param \Drupal\ticket\Entity\TicketTypeInterface $ticket_type
   *   The current Ticket.
   *
   * @return string
   *   The Ticket title.
   */
  public function addPageTitle(TicketTypeInterface $ticket_type) {
    return $this->t('Create @name', ['@name' => $ticket_type->label()]);
  }

}
