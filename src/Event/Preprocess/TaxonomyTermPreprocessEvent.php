<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class TaxonomyTermPreprocessEvent.
 *
 * @package Drupal\preprocess_event\Event
 */
final class TaxonomyTermPreprocessEvent extends ContentEntityPreprocessEvent {

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public static function getHook() {
    return 'taxonomy_term';
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
