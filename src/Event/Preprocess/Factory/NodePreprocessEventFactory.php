<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\NodePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\NodeEventVariables;

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
