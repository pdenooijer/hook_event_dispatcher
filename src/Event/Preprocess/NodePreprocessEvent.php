<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class NodePreprocessEvent.
 */
final class NodePreprocessEvent extends AbstractPreprocessEvent {

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public static function getHook() {
    return 'node';
  }

}
