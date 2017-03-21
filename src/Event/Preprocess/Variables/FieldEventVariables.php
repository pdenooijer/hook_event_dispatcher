<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

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
  public function &getElement() {
    return $this->variables['element'];
  }

  /**
   * Get the items array by reference.
   *
   * @return array
   *   Items array reference.
   */
  public function &getItems() {
    return $this->variables['items'];
  }

}
