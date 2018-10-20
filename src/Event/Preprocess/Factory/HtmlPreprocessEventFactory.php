<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\HtmlPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\HtmlEventVariables;

/**
 * Class HtmlPreprocessEventFactory.
 */
final class HtmlPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables) {
    return new HtmlPreprocessEvent(new HtmlEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook() {
    return HtmlPreprocessEvent::getHook();
  }

}
