<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Interface PreprocessEntityEventInterface.
 */
interface PreprocessEntityEventInterface extends PreprocessEventInterface {

  /**
   * Get the event name, with optional bundle and view mode.
   *
   * @param string $bundle
   *   Optional bundle.
   * @param string $viewMode
   *   Optional view mode.
   *
   * @return string
   *   Event name.
   */
  public static function name($bundle = '', $viewMode = '');

  /**
   * Get the Entity variables.
   *
   * @return \Drupal\preprocess_event_dispatcher\Variables\AbstractEntityEventVariables
   *   Entity variables.
   */
  public function getVariables();

}
