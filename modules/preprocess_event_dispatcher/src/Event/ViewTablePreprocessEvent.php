<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class ViewTablePreprocessEvent.
 */
final class ViewTablePreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'views_view_table';
  }

}
