<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class EntityEventVariables.
 */
abstract class AbstractEntityEventVariables extends AbstractEventVariables {

  /**
   * Get the Entity.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *   Entity.
   */
  abstract public function getEntity();

  /**
   * Get the Entity type.
   *
   * @return string
   *   Entity type.
   */
  public function getEntityType() {
    return $this->get('theme_hook_original');
  }

  /**
   * Get the Entity bundle.
   *
   * @return string
   *   Entity bundle.
   */
  public function getEntityBundle() {
    return $this->getEntity()->bundle();
  }

  /**
   * Get the view mode.
   *
   * @return string
   *   View mode.
   */
  public function getViewMode() {
    return $this->get('view_mode');
  }

}
