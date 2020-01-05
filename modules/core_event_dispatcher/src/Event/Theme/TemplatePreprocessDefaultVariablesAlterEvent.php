<?php

namespace Drupal\core_event_dispatcher\Event\Theme;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class TemplatePreprocessDefaultVariablesAlterEvent.
 */
final class TemplatePreprocessDefaultVariablesAlterEvent extends Event implements EventInterface {

  /**
   * Default template variables.
   *
   * @var array
   */
  private $variables;

  /**
   * TemplatePreprocessDefaultVariablesAlterEvent constructor.
   *
   * @param array $variables
   *   The associative array of default template variables, as set up by
   *   _template_preprocess_default_variables(). Passed by reference.
   *
   * @see hook_template_preprocess_default_variables_alter()
   */
  public function __construct(array &$variables) {
    $this->variables = &$variables;
  }

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::TEMPLATE_PREPROCESS_DEFAULT_VARIABLES_ALTER;
  }

  /**
   * Get the default template variables by reference.
   *
   * @return array
   *   The associative array of default template variables, as set up by
   *   _template_preprocess_default_variables(). Passed by reference.
   */
  public function &getVariables(): array {
    return $this->variables;
  }

}
