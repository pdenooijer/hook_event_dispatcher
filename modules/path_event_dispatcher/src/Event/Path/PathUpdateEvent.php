<?php

namespace Drupal\path_event_dispatcher\Event\Path;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class UpdatePathEvent.
 */
final class PathUpdateEvent extends AbstractPathEvent {

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::PATH_UPDATE;
  }

}
