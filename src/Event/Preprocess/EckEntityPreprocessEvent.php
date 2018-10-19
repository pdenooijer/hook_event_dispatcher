<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class EckEntityPreprocessEvent.
 */
final class EckEntityPreprocessEvent extends ContentEntityPreprocessEvent {

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public static function getHook() {
    return 'eck_entity';
  }

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public function getComposedName() {
    return self::name();
  }

}
