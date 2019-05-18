<?php

namespace Drupal\preprocess_event_dispatcher\Factory;

use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\FieldPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\FieldEventVariables;

/**
 * Class FieldPreprocessEventFactory.
 */
final class FieldPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables): AbstractPreprocessEvent {
    return new FieldPreprocessEvent(new FieldEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook(): string {
    return FieldPreprocessEvent::getHook();
  }

}
