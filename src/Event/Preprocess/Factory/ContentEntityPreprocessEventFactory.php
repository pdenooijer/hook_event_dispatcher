<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\ContentEntityPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ContentEntityEventVariables;

/**
 * Class ContentEntityPreprocessEventFactory.
 */
final class ContentEntityPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with the Variables object embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\ContentEntityPreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables) {
    return new ContentEntityPreprocessEvent(new ContentEntityEventVariables($variables));
  }

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook() {
    return ContentEntityPreprocessEvent::getHook();
  }

}
