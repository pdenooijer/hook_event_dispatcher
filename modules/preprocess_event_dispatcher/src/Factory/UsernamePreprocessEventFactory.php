<?php

namespace Drupal\preprocess_event_dispatcher\Factory;

use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\UsernamePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\UsernameEventVariables;

/**
 * Class UsernamePreprocessEventFactory.
 */
final class UsernamePreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables): AbstractPreprocessEvent {
    return new UsernamePreprocessEvent(new UsernameEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook(): string {
    return UsernamePreprocessEvent::getHook();
  }

}
