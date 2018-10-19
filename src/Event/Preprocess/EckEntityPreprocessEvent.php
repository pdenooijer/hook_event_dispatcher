<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class EckEntityPreprocessEvent.
 */
final class EckEntityPreprocessEvent extends ContentEntityPreprocessEvent {

  /**
   * {@inheritdoc}
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
