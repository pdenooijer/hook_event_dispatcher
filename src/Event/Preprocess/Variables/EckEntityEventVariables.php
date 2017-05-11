<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class EckEntityEventVariables.
 */
class EckEntityEventVariables extends AbstractEventVariables {

  /**
   * Get the EckEntity.
   *
   * @return \Drupal\eck\Entity\EckEntity
   *   EckEntity.
   */
  public function getEntity() {
    return $this->variables['entity']['#entity'];
  }

  /**
   * Get the EckEntity type.
   *
   * @return string
   *   Entity type.
   */
  public function getEntityType() {
    return $this->variables['entity']['#entity_type'];
  }

}
