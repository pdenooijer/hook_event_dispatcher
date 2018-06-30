<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class EntityPredeleteEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Entity
 */
class EntityPredeleteEvent extends BaseEntityEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::ENTITY_PRE_DELETE;
  }

}
