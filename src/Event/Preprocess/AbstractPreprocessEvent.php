<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AbstractPreprocessEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Preprocess
 *
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class AbstractPreprocessEvent extends Event implements PreprocessEventInterface {

  /**
   * Event variables.
   *
   * @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables
   */
  protected $variables;

  /**
   * PreprocessEvent constructor.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables $variables
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
    return static::DISPATCH_NAME_PREFIX . static::getHook();
  }

  /**
   * Get the template variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables
   *   Template variables.
   */
  public function getVariables() {
    return $this->variables;
  }

}
