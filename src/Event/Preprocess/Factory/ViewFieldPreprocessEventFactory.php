<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\ViewFieldPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewFieldEventVariables;

/**
 * Class ViewFieldPreprocessEventFactory.
 */
final class ViewFieldPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables) {
    return new ViewFieldPreprocessEvent(new ViewFieldEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook() {
    return ViewFieldPreprocessEvent::getHook();
  }

}
