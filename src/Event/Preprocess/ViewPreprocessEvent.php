<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

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
