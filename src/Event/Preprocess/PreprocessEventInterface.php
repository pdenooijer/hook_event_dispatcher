<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

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
   * Get the template variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables
   *   Template variables.
   */
  public function getVariables();

}
