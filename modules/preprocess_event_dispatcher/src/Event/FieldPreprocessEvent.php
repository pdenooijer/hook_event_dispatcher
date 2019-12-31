<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class FieldPreprocessEvent.
 */
final class FieldPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook(): string {
    return 'field';
  }

}
