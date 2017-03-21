<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class FieldPreprocessEvent.
 */
final class FieldPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public static function getHook() {
    return 'field';
  }

}
