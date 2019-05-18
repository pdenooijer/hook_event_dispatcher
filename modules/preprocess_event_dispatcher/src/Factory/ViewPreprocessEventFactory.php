<?php

namespace Drupal\preprocess_event_dispatcher\Factory;

use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\ViewPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\ViewEventVariables;

/**
 * Class ViewPreprocessEventFactory.
 */
final class ViewPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables): AbstractPreprocessEvent {
    return new ViewPreprocessEvent(new ViewEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook(): string {
    return ViewPreprocessEvent::getHook();
  }

}
