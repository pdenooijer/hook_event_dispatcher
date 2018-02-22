<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class UsernamePreprocessEvent.
 */
final class UsernamePreprocessEvent extends AbstractPreprocessEvent {

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public static function getHook() {
    return 'username';
  }

}
