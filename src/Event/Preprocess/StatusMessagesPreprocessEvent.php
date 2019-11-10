<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

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
