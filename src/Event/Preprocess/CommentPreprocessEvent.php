<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class CommentPreprocessEvent.
 */
final class CommentPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public static function getHook() {
    return 'comment';
  }

}
