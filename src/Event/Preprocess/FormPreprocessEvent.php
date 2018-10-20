<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class FormPreprocessEvent.
 */
final class FormPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'form';
  }

}
