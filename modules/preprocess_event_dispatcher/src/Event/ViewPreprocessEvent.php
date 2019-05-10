<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class ViewPreprocessEvent.
 */
final class ViewPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'views_view';
  }

}
