<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class ImagePreprocessEvent.
 */
final class ImagePreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'image';
  }

}
