<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Interface ComposedPreprocessEventInterface.
 */
interface ComposedPreprocessEventInterface extends PreprocessEventInterface {

  /**
   * Get the composed hook name.
   *
   * @return string
   *   The composed hook name.
   */
  public function getComposedName();

}
