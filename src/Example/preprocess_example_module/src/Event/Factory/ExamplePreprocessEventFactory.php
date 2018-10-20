<?php

namespace Drupal\preprocess_example_module\Event\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\Factory\PreprocessEventFactoryInterface;
use Drupal\preprocess_example_module\Event\Variables\ExampleEventVariables;
use Drupal\preprocess_example_module\Event\ExamplePreprocessEvent;

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
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\AbstractPreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables) {
    return new ExamplePreprocessEvent(
      new ExampleEventVariables($variables)
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook() {
    return ExamplePreprocessEvent::getHook();
  }

}
