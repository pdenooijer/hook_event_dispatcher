<?php

namespace Drupal\preprocess_event_dispatcher\Factory;

use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\ViewTablePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\ViewTableEventVariables;

/**
 * Class ViewTablePreprocessEventFactory.
 */
final class ViewTablePreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables): AbstractPreprocessEvent {
    return new ViewTablePreprocessEvent(new ViewTableEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook(): string {
    return ViewTablePreprocessEvent::getHook();
  }

}
