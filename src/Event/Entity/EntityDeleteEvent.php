<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class EntityDeleteEvent.
 */
class EntityDeleteEvent extends BaseEntityEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::ENTITY_DELETE;
  }

}
