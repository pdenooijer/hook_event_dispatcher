<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;

/**
 * Class EntityUpdateEvent
 * @package Drupal\hook_event_dispatcher\Event\Entity
 */
class EntityUpdateEvent extends BaseEntityEvent {

  /**
   * @inheritdoc.
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::ENTITY_UPDATE;
  }
}