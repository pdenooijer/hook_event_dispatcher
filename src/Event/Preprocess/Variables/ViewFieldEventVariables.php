<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class ViewFieldEventVariables.
 */
class ViewFieldEventVariables extends AbstractEventVariables {

  /**
   * Get the field.
   *
   * @return Field
   *   Field.
   */
  public function getField() {
    return $this->variables['field'];
  }

  /**
   * Get the output.
   *
   * @return Markup
   *   Output.
   */
  public function getOutput() {
    return $this->variables['output'];
  }

  /**
   * Get the row.
   *
   * @return ResultRow
   *   Row.
   */
  public function getRow() {
    return $this->variables['row'];
  }

  /**
   * Get the view.
   *
   * @return ViewExecutable
   *   View.
   */
  public function getView() {
    return $this->variables['view'];
  }

}
