<?php

namespace Drupal\preprocess_event_dispatcher\Factory;

use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\StatusMessagesPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\StatusMessagesEventVariables;

/**
 * Class StatusMessagesPreprocessEventFactory.
 */
final class StatusMessagesPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables): AbstractPreprocessEvent {
    return new StatusMessagesPreprocessEvent(new StatusMessagesEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook(): string {
    return StatusMessagesPreprocessEvent::getHook();
  }

}
