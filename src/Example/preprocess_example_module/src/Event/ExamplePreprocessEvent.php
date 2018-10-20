<?php

namespace Drupal\preprocess_example_module\Event;

use Drupal\hook_event_dispatcher\Event\Preprocess\AbstractPreprocessEvent;

/**
 * Class ExamplePreprocessEvent.
 */
class ExamplePreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'example';
  }

}
