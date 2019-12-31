<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class CommentPreprocessEvent.
 */
final class CommentPreprocessEvent extends AbstractPreprocessEntityEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook(): string {
    return 'comment';
  }

}
