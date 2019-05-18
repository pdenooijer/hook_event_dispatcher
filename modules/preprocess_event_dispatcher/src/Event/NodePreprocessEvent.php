<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class NodePreprocessEvent.
 */
final class NodePreprocessEvent extends AbstractPreprocessEntityEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook(): string {
    return 'node';
  }

}
