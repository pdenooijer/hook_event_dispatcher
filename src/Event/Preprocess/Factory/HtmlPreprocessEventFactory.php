<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\HtmlPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\HtmlEventVariables;

/**
 * Class HtmlPreprocessEventFactory.
 */
final class HtmlPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with EventVariables embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\HtmlPreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables) {
    return new HtmlPreprocessEvent(new HtmlEventVariables($variables));
  }

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook() {
    return HtmlPreprocessEvent::getHook();
  }

}
