<?php

namespace Drupal\preprocess_event_dispatcher\Factory;

use Drupal\preprocess_event_dispatcher\Event\CommentPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\CommentEventVariables;

/**
 * Class CommentPreprocessEventFactory.
 */
final class CommentPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables) {
    return new CommentPreprocessEvent(new CommentEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook() {
    return CommentPreprocessEvent::getHook();
  }

}
