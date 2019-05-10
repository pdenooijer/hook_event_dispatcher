<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class ViewFieldPreprocessEvent.
 */
final class ViewFieldPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'views_view_field';
  }

}
