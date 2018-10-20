<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AbstractPreprocessEvent.
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
   * {@inheritdoc}
   */
  public static function name() {
    return static::DISPATCH_NAME_PREFIX . static::getHook();
  }

  /**
   * {@inheritdoc}
   */
  public function getVariables() {
    return $this->variables;
  }

}
