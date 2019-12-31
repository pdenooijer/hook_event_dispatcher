<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class PagePreprocessEvent.
 */
final class PagePreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook(): string {
    return 'page';
  }

}
