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
    return $this->variables['eck_entity'];
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
    return $this->variables['bundle'];
  }

  /**
   * {@inheritdoc}
   */
  public function getViewMode() {
    return $this->variables['elements']['#view_mode'];
  }

}
