<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class BlockPreprocessEvent.
 */
final class BlockPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public static function getHook() {
    return 'block';
  }

}
