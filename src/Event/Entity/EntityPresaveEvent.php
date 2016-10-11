<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;

/**
 * Class EntityPresaveEvent
 * @package Drupal\hook_event_dispatcher\Event\Entity
 */
class EntityPresaveEvent extends BaseEntityEvent {

  /**
   * @inheritdoc.
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::ENTITY_PRE_SAVE;
  }
}