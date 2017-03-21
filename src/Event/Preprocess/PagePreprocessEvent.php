<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class PagePreprocessEvent.
 */
final class PagePreprocessEvent extends AbstractPreprocessEvent {

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public static function getHook() {
    return 'page';
  }

}
