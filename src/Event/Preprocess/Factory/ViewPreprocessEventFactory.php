<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\ViewPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewEventVariables;

/**
 * Class ViewPreprocessEventFactory.
 */
final class ViewPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with EventVariables embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\ViewPreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables) {
    return new ViewPreprocessEvent(new ViewEventVariables($variables));
  }

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook() {
    return ViewPreprocessEvent::getHook();
  }

}
