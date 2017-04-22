<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\ViewFieldPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewFieldEventVariables;

/**
 * Class ViewFieldPreprocessEventFactory.
 */
final class ViewFieldPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with EventVariables embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\ViewFieldPreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables) {
    return new ViewFieldPreprocessEvent(new ViewFieldEventVariables($variables));
  }

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook() {
    return ViewFieldPreprocessEvent::getHook();
  }

}
