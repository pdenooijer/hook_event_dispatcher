<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class BlockPreprocessEvent.
 */
final class BlockPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook(): string {
    return 'block';
  }

}
