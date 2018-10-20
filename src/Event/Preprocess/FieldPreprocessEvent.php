<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class FieldPreprocessEvent.
 */
final class FieldPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'field';
  }

}
