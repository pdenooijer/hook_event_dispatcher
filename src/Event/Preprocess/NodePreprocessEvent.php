<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class NodePreprocessEvent.
 */
final class NodePreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'node';
  }

}
