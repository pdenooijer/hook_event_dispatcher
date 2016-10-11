<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;

/**
 * Class EntityDeleteEvent
 * @package Drupal\hook_event_dispatcher\Event\Entity
 */
class EntityDeleteEvent extends BaseEntityEvent {

  /**
   * @inheritdoc.
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::ENTITY_DELETE;
  }
}