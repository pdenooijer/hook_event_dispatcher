<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class TaxonomyTermPreprocessEvent.
 */
final class TaxonomyTermPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'taxonomy_term';
  }

}
