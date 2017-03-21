<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AbstractPreprocessEvent.
 */
abstract class AbstractPreprocessEvent extends Event implements PreprocessEventInterface {

  /**
   * Event variables.
   *
   * @var AbstractEventVariables
   */
  protected $variables;

  /**
   * PreprocessEvent constructor.
   *
   * @param AbstractEventVariables $variables
   *   The variables.
   */
  public function __construct(AbstractEventVariables $variables) {
    $this->variables = $variables;
  }

  /**
   * Get the Event name.
   *
   * @return string
   *   Event name.
   */
  public static function name() {
    return 'preprocess_' . static::getHook();
  }

  /**
   * Get the template variables.
   *
   * @return AbstractEventVariables
   *   Template variables.
   */
  public function getVariables() {
    return $this->variables;
  }

}
