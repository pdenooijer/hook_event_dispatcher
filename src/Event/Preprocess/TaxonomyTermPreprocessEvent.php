<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class TaxonomyTermPreprocessEvent.
 */
final class TaxonomyTermPreprocessEvent extends ContentEntityPreprocessEvent {

  /**
   * {@inheritdoc}
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
