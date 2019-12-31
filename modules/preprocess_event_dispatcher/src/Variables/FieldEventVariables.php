<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

/**
 * Class FieldEventVariables.
 */
class FieldEventVariables extends AbstractEventVariables {

  /**
   * Get the element array by reference.
   *
   * @return array
   *   Element array reference.
   */
  public function &getElement(): array {
    return $this->variables['element'];
  }

  /**
   * Get the items array by reference.
   *
   * @return array
   *   Items array reference.
   */
  public function &getItems(): array {
    return $this->variables['items'];
  }

}
