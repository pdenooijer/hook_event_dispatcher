<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class HtmlPreprocessEvent.
 */
final class HtmlPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public static function getHook() {
    return 'html';
  }

}
