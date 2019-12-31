<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class StatusMessagesPreprocessEvent.
 */
final class StatusMessagesPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook(): string {
    return 'status_messages';
  }

}
