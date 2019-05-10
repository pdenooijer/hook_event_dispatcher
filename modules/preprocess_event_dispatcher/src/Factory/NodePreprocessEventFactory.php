<?php

namespace Drupal\preprocess_event_dispatcher\Factory;

use Drupal\preprocess_event_dispatcher\Event\NodePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\NodeEventVariables;

/**
 * Class NodePreprocessEventFactory.
 */
final class NodePreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables) {
    return new NodePreprocessEvent(new NodeEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook() {
    return NodePreprocessEvent::getHook();
  }

}
