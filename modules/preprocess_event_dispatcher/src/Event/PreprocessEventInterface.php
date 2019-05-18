<?php

namespace Drupal\preprocess_event_dispatcher\Event;

use Drupal\preprocess_event_dispatcher\Variables\AbstractEventVariables;

/**
 * Interface PreprocessEventInterface.
 */
interface PreprocessEventInterface {

  public const DISPATCH_NAME_PREFIX = 'preprocess_';

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public static function getHook(): string;

  /**
   * Get the Event name.
   *
   * @return string
   *   Event name.
   */
  public static function name(): string;

  /**
   * Get the variables.
   *
   * @return \Drupal\preprocess_event_dispatcher\Variables\AbstractEventVariables
   *   Variables.
   */
  public function getVariables(): AbstractEventVariables;

}
