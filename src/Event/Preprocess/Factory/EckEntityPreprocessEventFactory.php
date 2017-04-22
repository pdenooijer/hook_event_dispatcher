<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\EckEntityPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\EckEntityEventVariables;

/**
 * Class EckEntityPreprocessEventFactory.
 */
final class EckEntityPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with the Variables object embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\EckEntityPreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables) {
    return new EckEntityPreprocessEvent(new EckEntityEventVariables($variables));
  }

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook() {
    return EckEntityPreprocessEvent::getHook();
  }

}
