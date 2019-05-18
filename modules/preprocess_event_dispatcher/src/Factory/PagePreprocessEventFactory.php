<?php

namespace Drupal\preprocess_event_dispatcher\Factory;

use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\PagePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\PageEventVariables;

/**
 * Class PagePreprocessEventFactory.
 */
final class PagePreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables): AbstractPreprocessEvent {
    return new PagePreprocessEvent(new PageEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook(): string {
    return PagePreprocessEvent::getHook();
  }

}
