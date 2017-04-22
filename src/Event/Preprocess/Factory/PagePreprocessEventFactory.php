<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\PagePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\PageEventVariables;

/**
 * Class PagePreprocessEventFactory.
 */
final class PagePreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with EventVariables embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\PagePreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables) {
    return new PagePreprocessEvent(new PageEventVariables($variables));
  }

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook() {
    return PagePreprocessEvent::getHook();
  }

}
