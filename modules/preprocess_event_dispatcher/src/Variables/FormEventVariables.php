<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

/**
 * Class FormEventVariables.
 */
class FormEventVariables extends AbstractEventVariables {

  /**
   * Get the element array by reference.
   *
   * @return array
   *   Element array reference.
   */
  public function &getElement(): array {
    return $this->variables['element'];
  }

}
