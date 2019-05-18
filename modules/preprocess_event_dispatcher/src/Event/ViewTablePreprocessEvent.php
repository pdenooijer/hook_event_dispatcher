<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class ViewTablePreprocessEvent.
 */
final class ViewTablePreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook(): string {
    return 'views_view_table';
  }

}
