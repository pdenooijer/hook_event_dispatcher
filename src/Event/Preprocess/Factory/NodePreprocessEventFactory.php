<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\NodePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\NodeEventVariables;

/**
 * Class NodePreprocessEventFactory.
 */
final class NodePreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with EventVariables embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\NodePreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables) {
    return new NodePreprocessEvent(new NodeEventVariables($variables));
  }

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook() {
    return NodePreprocessEvent::getHook();
  }

}
