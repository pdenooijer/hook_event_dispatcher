<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\EckEntityPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\EckEntityEventVariables;

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
