<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class EckEntityPreprocessEvent.
 */
final class EckEntityPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public static function getHook() {
    return 'eck_entity';
  }

}
