<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables;

/**
 * Interface PreprocessEventInterface.
 */
interface PreprocessEventInterface {

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
   * Get the template variables.
   *
   * @return AbstractEventVariables
   *   Template variables.
   */
  public function getVariables();

}
