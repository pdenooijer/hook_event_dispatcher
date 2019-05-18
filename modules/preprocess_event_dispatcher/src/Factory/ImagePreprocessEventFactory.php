<?php

namespace Drupal\preprocess_event_dispatcher\Factory;

use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\ImagePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\ImageEventVariables;

/**
 * Class ImagePreprocessEventFactory.
 */
final class ImagePreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables): AbstractPreprocessEvent {
    return new ImagePreprocessEvent(new ImageEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook(): string {
    return ImagePreprocessEvent::getHook();
  }

}
