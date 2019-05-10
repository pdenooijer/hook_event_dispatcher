<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class StatusMessagesPreprocessEvent.
 */
final class StatusMessagesPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'status_messages';
  }

}
