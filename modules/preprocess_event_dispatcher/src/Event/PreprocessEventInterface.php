<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Interface PreprocessEventInterface.
 */
interface PreprocessEventInterface {

  const DISPATCH_NAME_PREFIX = 'preprocess_';

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public static function getHook();

  /**
   * Get the Event name.
   *
   * @return string
   *   Event name.
   */
  public static function name();

  /**
   * Get the variables.
   *
   * @return \Drupal\preprocess_event_dispatcher\Variables\AbstractEventVariables
   *   Variables.
   */
  public function getVariables();

}
