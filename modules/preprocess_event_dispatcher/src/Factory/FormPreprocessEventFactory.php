<?php

namespace Drupal\preprocess_event_dispatcher\Factory;

use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\FormPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\FormEventVariables;

/**
 * Class FormPreprocessEventFactory.
 */
final class FormPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables): AbstractPreprocessEvent {
    return new FormPreprocessEvent(new FormEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook(): string {
    return FormPreprocessEvent::getHook();
  }

}
