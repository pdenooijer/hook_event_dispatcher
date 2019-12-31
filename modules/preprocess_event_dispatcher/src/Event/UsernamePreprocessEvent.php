<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class UsernamePreprocessEvent.
 */
final class UsernamePreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook(): string {
    return 'username';
  }

}
