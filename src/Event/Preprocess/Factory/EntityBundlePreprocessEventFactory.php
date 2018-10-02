<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\EntityBundlePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\EntityEventVariables;

/**
 * Class EntityBundlePreprocessEventFactory.
 */
final class EntityBundlePreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with the Variables object embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\EntityBundlePreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables) {
    return new EntityBundlePreprocessEvent(new EntityEventVariables($variables));
  }

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook() {
    return EntityBundlePreprocessEvent::getHook();
  }

}
