<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class ViewPreprocessEvent.
 */
final class ViewPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public static function getHook() {
    return 'views_view';
  }

}
