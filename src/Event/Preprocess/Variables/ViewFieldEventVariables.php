<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class ViewFieldEventVariables.
 */
class ViewFieldEventVariables extends AbstractEventVariables {

  /**
   * Get the field.
   *
   * @return \Drupal\views\Plugin\views\field\EntityField
   *   Field.
   */
  public function getField() {
    return $this->variables['field'];
  }

  /**
   * Get the output.
   *
   * @return \Drupal\views\Plugin\views\field\Markup
   *   Output.
   */
  public function getOutput() {
    return $this->variables['output'];
  }

  /**
   * Get the row.
   *
   * @return \Drupal\views\ResultRow
   *   Row.
   */
  public function getRow() {
    return $this->variables['row'];
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
