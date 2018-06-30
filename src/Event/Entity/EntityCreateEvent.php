<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class EntityCreateEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Entity
 */
class EntityCreateEvent extends BaseEntityEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::ENTITY_CREATE;
  }

}
