<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\UsernamePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\UsernameEventVariables;

/**
 * Class UsernamePreprocessEventFactory.
 */
final class UsernamePreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables) {
    return new UsernamePreprocessEvent(new UsernameEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook() {
    return UsernamePreprocessEvent::getHook();
  }

}
