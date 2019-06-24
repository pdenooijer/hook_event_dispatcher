<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\StatusMessagesPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\StatusMessagesEventVariables;

/**
 * Class StatusMessagesPreprocessEventFactory.
 */
final class StatusMessagesPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables) {
    return new StatusMessagesPreprocessEvent(new StatusMessagesEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook() {
    return StatusMessagesPreprocessEvent::getHook();
  }

}
