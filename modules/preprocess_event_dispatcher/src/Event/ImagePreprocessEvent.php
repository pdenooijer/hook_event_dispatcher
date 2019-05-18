<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class ImagePreprocessEvent.
 */
final class ImagePreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook(): string {
    return 'image';
  }

}
