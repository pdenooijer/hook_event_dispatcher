<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\BlockPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\BlockEventVariables;

/**
 * Class BlockPreprocessEventFactory.
 */
final class BlockPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with EventVariables embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\BlockPreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables) {
    return new BlockPreprocessEvent(new BlockEventVariables($variables));
  }

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook() {
    return BlockPreprocessEvent::getHook();
  }

}
