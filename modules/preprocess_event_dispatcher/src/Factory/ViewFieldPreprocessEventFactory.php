<?php

namespace Drupal\preprocess_event_dispatcher\Factory;

use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\ViewFieldPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\ViewFieldEventVariables;

/**
 * Class ViewFieldPreprocessEventFactory.
 */
final class ViewFieldPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables): AbstractPreprocessEvent {
    return new ViewFieldPreprocessEvent(new ViewFieldEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook(): string {
    return ViewFieldPreprocessEvent::getHook();
  }

}
