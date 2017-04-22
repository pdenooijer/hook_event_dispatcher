<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\FormPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\FormEventVariables;

/**
 * Class FormPreprocessEventFactory.
 */
final class FormPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with EventVariables embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\FormPreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables) {
    return new FormPreprocessEvent(new FormEventVariables($variables));
  }

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook() {
    return FormPreprocessEvent::getHook();
  }

}
