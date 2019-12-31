<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class HtmlPreprocessEvent.
 */
final class HtmlPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook(): string {
    return 'html';
  }

}
