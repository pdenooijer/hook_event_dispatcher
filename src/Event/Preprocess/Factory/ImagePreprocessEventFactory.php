<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\ImagePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ImageEventVariables;

/**
 * Class ImagePreprocessEventFactory.
 */
final class ImagePreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables) {
    return new ImagePreprocessEvent(new ImageEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook() {
    return ImagePreprocessEvent::getHook();
  }

}
