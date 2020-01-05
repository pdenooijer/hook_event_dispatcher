<?php

namespace Drupal\core_event_dispatcher\Event\Entity;

use Drupal\Core\Entity\EntityInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class EntityUpdateEvent.
 */
class EntityUpdateEvent extends AbstractEntityEvent {

  /**
   * Get the original Entity.
   *
   * @see hook_entity_update()
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *   The original entity.
   */
  public function getOriginalEntity(): EntityInterface {
    return $this->entity->original;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::ENTITY_UPDATE;
  }

}
