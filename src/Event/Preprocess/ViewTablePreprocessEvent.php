<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

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
