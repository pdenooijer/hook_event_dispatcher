<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class PagePreprocessEvent.
 */
final class PagePreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'page';
  }

}
