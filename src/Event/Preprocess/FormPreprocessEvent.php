<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class FormPreprocessEvent.
 */
final class FormPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public static function getHook() {
    return 'form';
  }

}
