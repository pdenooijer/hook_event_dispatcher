<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class ParagraphPreprocessEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Preprocess
 */
final class ParagraphPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'paragraph';
  }

}
