<?php

namespace Drupal\preprocess_event_dispatcher\Factory;

use Drupal\preprocess_event_dispatcher\Event\EckEntityPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\EckEntityEventVariables;

/**
 * Class EckEntityPreprocessEventFactory.
 */
final class EckEntityPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables) {
    return new EckEntityPreprocessEvent(new EckEntityEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook() {
    return EckEntityPreprocessEvent::getHook();
  }

}
