<?php

namespace Drupal\hook_event_dispatcher\Event\Path;

use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;

/**
 * Class UpdatePathEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Path
 */
final class PathUpdateEvent extends BasePathEvent {

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::PATH_UPDATE;
  }

}
