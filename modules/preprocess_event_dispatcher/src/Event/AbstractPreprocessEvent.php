<?php

namespace Drupal\preprocess_event_dispatcher\Event;

use Drupal\preprocess_event_dispatcher\Variables\AbstractEventVariables;
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
   * @var \Drupal\preprocess_event_dispatcher\Variables\AbstractEventVariables
   */
  protected $variables;

  /**
   * PreprocessEvent constructor.
   *
   * @param \Drupal\preprocess_event_dispatcher\Variables\AbstractEventVariables $variables
   *   The variables.
   */
  public function __construct(AbstractEventVariables $variables) {
    $this->variables = $variables;
  }

  /**
   * {@inheritdoc}
   */
  public static function name(): string {
    return static::DISPATCH_NAME_PREFIX . static::getHook();
  }

  /**
   * {@inheritdoc}
   */
  public function getVariables(): AbstractEventVariables {
    return $this->variables;
  }

}
