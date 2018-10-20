<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class EntityPresaveEvent.
 */
class EntityPresaveEvent extends BaseEntityEvent {

  /**
   * Get the original Entity.
   *
   * @see hook_entity_update()
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *   The original entity.
   */
  public function getOriginalEntity() {
    return $this->entity->original;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::ENTITY_PRE_SAVE;
  }

}
