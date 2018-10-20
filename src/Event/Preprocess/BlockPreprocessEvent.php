<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class BlockPreprocessEvent.
 */
final class BlockPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'block';
  }

}
