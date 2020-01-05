<?php

namespace Drupal\core_event_dispatcher\Event\Entity;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class EntityInsertEvent.
 */
class EntityInsertEvent extends AbstractEntityEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::ENTITY_INSERT;
  }

}
