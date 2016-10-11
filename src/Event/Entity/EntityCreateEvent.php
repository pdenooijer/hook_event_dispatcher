<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;

/**
 * Class EntityCreateEvent
 * @package Drupal\hook_event_dispatcher\Event\Entity
 */
class EntityCreateEvent extends BaseEntityEvent {

  /**
   * @inheritdoc.
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::ENTITY_CREATE;
  }
}