<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

use Drupal\views\ResultRow;
use Drupal\views\ViewExecutable;

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
  public function getRows(): ResultRow {
    return $this->variables['rows'];
  }

  /**
   * Get the view.
   *
   * @return \Drupal\views\ViewExecutable
   *   View.
   */
  public function getView(): ViewExecutable {
    return $this->variables['view'];
  }

}
