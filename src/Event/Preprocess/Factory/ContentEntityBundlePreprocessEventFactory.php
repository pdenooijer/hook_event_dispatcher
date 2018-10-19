<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\ContentEntityBundlePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ContentEntityEventVariables;

/**
 * Class ContentEntityBundlePreprocessEventFactory.
 */
final class ContentEntityBundlePreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with the Variables object embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\ContentEntityBundlePreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables) {
    return new ContentEntityBundlePreprocessEvent(new ContentEntityEventVariables($variables));
  }

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook() {
    return ContentEntityBundlePreprocessEvent::getHook();
  }

}
