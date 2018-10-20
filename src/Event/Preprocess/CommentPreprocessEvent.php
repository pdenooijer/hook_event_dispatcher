<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class CommentPreprocessEvent.
 */
final class CommentPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'comment';
  }

}
