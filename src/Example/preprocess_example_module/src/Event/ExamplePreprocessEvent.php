<?php

namespace Drupal\preprocess_example_module\Event;

use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;

/**
 * Class ExamplePreprocessEvent.
 */
class ExamplePreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook(): string {
    return 'example';
  }

}
