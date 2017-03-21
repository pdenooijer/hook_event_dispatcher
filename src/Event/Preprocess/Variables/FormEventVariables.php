<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

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
  public function &getElement() {
    return $this->variables['element'];
  }

}
