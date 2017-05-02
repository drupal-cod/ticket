<?php

namespace Drupal\ticket\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\ticket\Entity\RegistrationTypeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Registration routes.
 */
class RegistrationController extends ControllerBase implements ContainerInjectionInterface {
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
   * Displays add registration links for available registration types.
   *
   * Redirects to ticket/registrations/add/[registration_type]
   * if only one registration type is available.
   *
   * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
   *   A render array for a list of the registration types that can
   *   be added; however, if there is only one registration type defined
   *   for the site, the function will return a RedirectResponse to the
   *   Registration add page for that one registration type.
   */
  public function addPage() {
    $build = [
      '#theme' => 'registration_add_list',
      '#cache' => [
        'tags' => $this->entityManager()->getDefinition('registration_type')->getListCacheTags(),
      ],
    ];

    $registration = [];

    // Only use node types the user has access to.
    foreach ($this->entityManager()->getStorage('registration_type')->loadMultiple() as $registration_type) {
      $access = $this->entityManager()->getAccessControlHandler('registration_type')->createAccess($registration_type->id(), NULL, [], TRUE);
      if ($access->isAllowed()) {
        $registration[$registration_type->id()] = $registration_type;
      }
    }

    // Bypass the ticket/add listing if only one content type is available.
    if (count($registration) == 1) {
      $registration_type = array_shift($registration);
      return $this->redirect('registration.add', ['registration_type' => $registration_type->id()]);
    }

    $build['#content'] = $registration;

    return $build;
  }

  /**
   * Provides the registration submission form.
   *
   * @param \Drupal\ticket\Entity\RegistrationTypeInterface $registration_type
   *   The registration type entity for the registration.
   *
   * @return array
   *   A registration submission form.
   */
  public function add(RegistrationTypeInterface $registration_type) {
    $registration = $this->entityManager()->getStorage('registration')->create(['registration_type' => $registration_type->id()]);

    $form = $this->entityFormBuilder()->getForm($registration);

    return $form;
  }

  /**
   * The _title_callback for the registration.add route.
   *
   * @param \Drupal\ticket\Entity\RegistrationTypeInterface $registration_type
   *   The current Registration.
   *
   * @return string
   *   The Registration title.
   */
  public function addPageTitle(RegistrationTypeInterface $registration_type) {
    return $this->t('Create @name', ['@name' => $registration_type->label()]);
  }

}
