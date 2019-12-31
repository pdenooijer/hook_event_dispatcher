<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class TaxonomyTermPreprocessEvent.
 */
final class TaxonomyTermPreprocessEvent extends AbstractPreprocessEntityEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook(): string {
    return 'taxonomy_term';
  }

}
