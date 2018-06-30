<?php

namespace Drupal\hook_event_dispatcher\Event\Path;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class PathInsertEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Path
 */
final class PathInsertEvent extends BasePathEvent {

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::PATH_INSERT;
  }

}
