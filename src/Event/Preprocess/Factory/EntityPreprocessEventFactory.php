<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\EntityPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\EntityEventVariables;

/**
 * Class EntityPreprocessEventFactory.
 */
final class EntityPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with the Variables object embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\EntityPreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables) {
    return new EntityPreprocessEvent(new EntityEventVariables($variables));
  }

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook() {
    return EntityPreprocessEvent::getHook();
  }

}
