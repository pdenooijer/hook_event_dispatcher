<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

use Drupal\Core\Entity\EntityInterface;
use Drupal\eck\EckEntityInterface;

/**
 * Class EckEntityEventVariables.
 */
class EckEntityEventVariables extends AbstractEntityEventVariables {

  /**
   * Get the EckEntity.
   *
   * @return \Drupal\eck\EckEntityInterface
   *   EckEntity.
   */
  public function getEckEntity(): EckEntityInterface {
    return $this->variables['eck_entity'];
  }

  /**
   * {@inheritdoc}
   */
  public function getEntity(): EntityInterface {
    return $this->getEckEntity();
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityBundle(): string {
    return $this->variables['bundle'];
  }

  /**
   * {@inheritdoc}
   */
  public function getViewMode(): string {
    return $this->variables['elements']['#view_mode'];
  }

}
