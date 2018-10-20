<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class HtmlPreprocessEvent.
 */
final class HtmlPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'html';
  }

}
