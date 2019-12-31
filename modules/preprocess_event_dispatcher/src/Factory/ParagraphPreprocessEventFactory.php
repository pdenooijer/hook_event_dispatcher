<?php

namespace Drupal\preprocess_event_dispatcher\Factory;

use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\ParagraphPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\ParagraphEventVariables;

/**
 * Class ParagraphPreprocessEventFactory.
 */
final class ParagraphPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables): AbstractPreprocessEvent {
    return new ParagraphPreprocessEvent(new ParagraphEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook(): string {
    return ParagraphPreprocessEvent::getHook();
  }

}
