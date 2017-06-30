<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;

/**
 * Class EntityInsertEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Entity
 */
class EntityInsertEvent extends BaseEntityEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::ENTITY_INSERT;
  }

}
