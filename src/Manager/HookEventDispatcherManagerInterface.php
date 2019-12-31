<?php

namespace Drupal\hook_event_dispatcher\Manager;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class HookEventDispatcherManager.
 *
 * Wrapper class for the external dispatcher dependency. If this ever changes
 * we only have to change it once.
 */
interface HookEventDispatcherManagerInterface {

  /**
   * Registers an event dispatcher for given entity.
   *
   * @param \Drupal\hook_event_dispatcher\Event\EventInterface $event
   *   The event.
   *
   * @return \Symfony\Component\EventDispatcher\Event
   *   The event.
   */
  public function register(EventInterface $event): Event;

}
