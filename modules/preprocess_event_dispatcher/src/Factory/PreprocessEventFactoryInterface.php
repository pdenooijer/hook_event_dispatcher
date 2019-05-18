<?php

namespace Drupal\preprocess_event_dispatcher\Factory;

use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;

/**
 * Interface PreprocessEventFactoryInterface.
 */
interface PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with the Variables object embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables): AbstractPreprocessEvent;

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook(): string;

}
