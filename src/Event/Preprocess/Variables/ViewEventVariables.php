<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class ViewEventVariables.
 */
class ViewEventVariables extends AbstractEventVariables {

  /**
   * Get the rows.
   *
   * @return array
   *   Rows.
   */
  public function &getRows() {
    return $this->variables['rows'][0]['#rows'];
  }

  /**
   * Get the view.
   *
   * @return \Drupal\views\ViewExecutable
   *   View.
   */
  public function getView() {
    return $this->variables['view'];
  }

}
