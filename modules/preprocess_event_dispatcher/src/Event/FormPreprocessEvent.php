<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class FormPreprocessEvent.
 */
final class FormPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook(): string {
    return 'form';
  }

}
