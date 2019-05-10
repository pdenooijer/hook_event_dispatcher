<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

/**
 * Class ViewTableEventVariables.
 */
class ViewTableEventVariables extends AbstractEventVariables {

  /**
   * Get the row.
   *
   * @return \Drupal\views\ResultRow
   *   Row.
   */
  public function getRows() {
    return $this->variables['rows'];
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
