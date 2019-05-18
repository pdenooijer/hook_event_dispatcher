<?php

namespace Drupal\preprocess_example_module\Factory;

use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Factory\PreprocessEventFactoryInterface;
use Drupal\preprocess_example_module\Event\ExamplePreprocessEvent;
use Drupal\preprocess_example_module\Event\Variables\ExampleEventVariables;

/**
 * Class ExamplePreprocessEventFactory.
 */
class ExamplePreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with the Variables object embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables): AbstractPreprocessEvent {
    return new ExamplePreprocessEvent(
      new ExampleEventVariables($variables)
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook(): string {
    return ExamplePreprocessEvent::getHook();
  }

}
