<?php

namespace Drupal\preprocess_event_dispatcher\Factory;

use Drupal\preprocess_event_dispatcher\Event\ViewTablePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\ViewTableEventVariables;

/**
 * Class ViewTablePreprocessEventFactory.
 */
final class ViewTablePreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables) {
    return new ViewTablePreprocessEvent(new ViewTableEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook() {
    return ViewTablePreprocessEvent::getHook();
  }

}
