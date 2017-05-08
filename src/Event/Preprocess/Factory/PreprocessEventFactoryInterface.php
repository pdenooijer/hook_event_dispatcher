<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

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
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\AbstractPreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables);

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook();

}
