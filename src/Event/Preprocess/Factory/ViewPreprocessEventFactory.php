<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\ViewPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewEventVariables;

/**
 * Class ViewPreprocessEventFactory.
 */
final class ViewPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables) {
    return new ViewPreprocessEvent(new ViewEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook() {
    return ViewPreprocessEvent::getHook();
  }

}
