<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

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
