<?php

namespace Drupal\ticket\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Registration type entity.
 *
 * @ConfigEntityType(
 *   id = "registration_type",
 *   label = @Translation("Registration Type"),
 *   handlers = {
 *     "list_builder" = "Drupal\ticket\RegistrationTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\ticket\Form\RegistrationTypeForm",
 *       "edit" = "Drupal\ticket\Form\RegistrationTypeForm",
 *       "delete" = "Drupal\ticket\Form\RegistrationTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\ticket\RegistrationTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "registration_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "registration",
 *   entity_keys = {
 *     "id" = "trid",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/ticket/registrations/type/{registration_type}",
 *     "add-form" = "/ticket/registrations/type/add",
 *     "edit-form" = "/ticket/registrations/type/{registration_type}/edit",
 *     "delete-form" = "/ticket/registrations/type/{registration_type}/delete",
 *     "collection" = "/ticket/registrations/type"
 *   }
 * )
 */
class RegistrationType extends ConfigEntityBundleBase implements RegistrationTypeInterface {

  /**
   * The Registration Type ID.
   *
   * @var string
   */
  protected $trid;

  /**
   * The Registration Type label.
   *
   * @var string
   */
  protected $label;

  /**
   * Description of the Registration Type.
   *
   * @var string
   */
  protected $description;

  /**
   * {@inheritdoc}
   */
  public function id() {
    return $this->trid;
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel() {
    return $this->label;
  }

  /**
   * {@inheritdoc}
   */
  public function isLocked() {
    if (isset($this->trid) && !empty($this->trid)) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

}
