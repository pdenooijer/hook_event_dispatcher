<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class UsernamePreprocessEvent.
 */
final class UsernamePreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'username';
  }

}
