<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class EntityPreprocessEvent.
 */
final class EntityPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public static function getHook() {
    return 'entity';
  }

}
