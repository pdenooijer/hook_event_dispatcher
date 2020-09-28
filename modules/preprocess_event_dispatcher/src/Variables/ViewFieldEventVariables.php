<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

use Drupal\views\Plugin\views\field\FieldHandlerInterface;
use Drupal\views\Plugin\views\field\Markup;
use Drupal\views\ResultRow;
use Drupal\views\ViewExecutable;

/**
 * Class ViewFieldEventVariables.
 */
class ViewFieldEventVariables extends AbstractEventVariables {

  /**
   * Get the field.
   *
   * @return \Drupal\views\Plugin\views\field\FieldHandlerInterface
   *   Field.
   */
  public function getField(): FieldHandlerInterface {
    return $this->variables['field'];
  }

  /**
   * Get the output.
   *
   * @return \Drupal\views\Plugin\views\field\Markup
   *   Output.
   */
  public function getOutput(): Markup {
    return $this->variables['output'];
  }

  /**
   * Get the row.
   *
   * @return \Drupal\views\ResultRow
   *   Row.
   */
  public function getRow(): ResultRow {
    return $this->variables['row'];
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
