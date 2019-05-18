<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class ParagraphPreprocessEvent.
 */
final class ParagraphPreprocessEvent extends AbstractPreprocessEntityEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook(): string {
    return 'paragraph';
  }

}
