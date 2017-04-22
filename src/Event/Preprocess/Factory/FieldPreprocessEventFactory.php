<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\FieldPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\FieldEventVariables;

/**
 * Class FieldPreprocessEventFactory.
 */
final class FieldPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with EventVariables embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\FieldPreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables) {
    return new FieldPreprocessEvent(new FieldEventVariables($variables));
  }

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook() {
    return FieldPreprocessEvent::getHook();
  }

}
