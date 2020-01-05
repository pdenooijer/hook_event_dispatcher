<?php

namespace Drupal\core_event_dispatcher\Event\Entity;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class EntityPredeleteEvent.
 */
class EntityPredeleteEvent extends AbstractEntityEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::ENTITY_PRE_DELETE;
  }

}
