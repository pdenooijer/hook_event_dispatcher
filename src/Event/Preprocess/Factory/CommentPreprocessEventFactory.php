<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\CommentPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\CommentEventVariables;

/**
 * Class CommentPreprocessEventFactory.
 */
final class CommentPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with EventVariables embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\CommentPreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables) {
    return new CommentPreprocessEvent(new CommentEventVariables($variables));
  }

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook() {
    return CommentPreprocessEvent::getHook();
  }

}
