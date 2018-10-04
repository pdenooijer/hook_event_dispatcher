<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class EntityEventVariables.
 */
class ContentEntityEventVariables extends AbstractEventVariables {

  /**
   * Get the Entity.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *   EckEntity.
   */
  public function getEntity() {
    return $this->get($this->getEntityType());
  }

  /**
   * Get the Entity type.
   *
   * @return string
   *   Entity type.
   */
  public function getEntityType() {
    return $this->get('elements')['#entity_type'];
  }

  /**
   * Get the Entity bundle.
   *
   * @return string
   *   Entity type.
   */
  public function getEntityBundle() {
    return $this->getEntity()->bundle();
  }

  /**
   * Get the view mode.
   *
   * @return string
   *   Entity type.
   */
  public function getViewMode() {
    return $this->get('view_mode');
  }

}
