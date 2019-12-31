<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

use Drupal\Core\Entity\EntityInterface;

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
  abstract public function getEntity(): EntityInterface;

  /**
   * Get the Entity type.
   *
   * @return string
   *   Entity type.
   */
  public function getEntityType(): string {
    return $this->get('theme_hook_original', '');
  }

  /**
   * Get the Entity bundle.
   *
   * @return string
   *   Entity bundle.
   */
  public function getEntityBundle(): string {
    return $this->getEntity()->bundle();
  }

  /**
   * Get the view mode.
   *
   * @return string
   *   View mode.
   */
  public function getViewMode(): string {
    return $this->get('view_mode', '');
  }

}
