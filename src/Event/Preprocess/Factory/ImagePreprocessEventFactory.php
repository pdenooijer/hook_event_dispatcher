<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\ImagePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ImageEventVariables;

/**
 * Class ImagePreprocessEventFactory.
 */
final class ImagePreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with EventVariables embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\ImagePreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables) {
    return new ImagePreprocessEvent(new ImageEventVariables($variables));
  }

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook() {
    return ImagePreprocessEvent::getHook();
  }

}
