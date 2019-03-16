<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\ViewTablePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewTableEventVariables;

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
