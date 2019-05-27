<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class EckEntityEventVariables.
 */
class EckEntityEventVariables extends AbstractEntityEventVariables {

  /**
   * Get the EckEntity.
   *
   * @return \Drupal\eck\Entity\EckEntity
   *   EckEntity.
   */
  public function getEckEntity() {
    return $this->variables['entity']['#entity'];
  }

  /**
   * {@inheritdoc}
   */
  public function getEntity() {
    return $this->getEckEntity();
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityBundle() {
    return $this->variables['entity']['#entity_type'];
  }

  /**
   * {@inheritdoc}
   */
  public function getViewMode() {
    return $this->variables['entity']['#view_mode'];
  }

}
