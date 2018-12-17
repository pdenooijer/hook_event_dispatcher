<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class ParagraphPreprocessEvent.
 */
final class ParagraphPreprocessEvent extends AbstractPreprocessEntityEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'paragraph';
  }

}
