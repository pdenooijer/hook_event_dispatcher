<?php

namespace Drupal\preprocess_event_dispatcher\Service;

/**
 * Interface PreprocessEventServiceInterface.
 */
interface PreprocessEventServiceInterface {

  /**
   * Create and dispatch the event.
   *
   * @param string $hook
   *   The hook name.
   * @param array $variables
   *   Variables.
   */
  public function createAndDispatchKnownEvents(string $hook, array &$variables): void;

}
