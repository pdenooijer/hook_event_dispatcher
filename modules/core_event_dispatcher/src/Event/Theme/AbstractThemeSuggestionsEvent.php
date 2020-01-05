<?php

namespace Drupal\core_event_dispatcher\Event\Theme;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AbstractThemeSuggestionsEvent.
 */
abstract class AbstractThemeSuggestionsEvent extends Event implements EventInterface {

  /**
   * Array of suggestions.
   *
   * @var array
   */
  private $suggestions;
  /**
   * Variables.
   *
   * @var array
   */
  private $variables;
  /**
   * Hook name.
   *
   * @var string
   */
  private $hook;

  /**
   * AbstractThemeSuggestionsEvent constructor.
   *
   * @param array $suggestions
   *   Suggestions.
   * @param array $variables
   *   Variables.
   * @param string $hook
   *   Hook name.
   */
  public function __construct(array &$suggestions, array $variables, string $hook) {
    $this->suggestions = &$suggestions;
    $this->variables = $variables;
    $this->hook = $hook;
  }

  /**
   * Get suggestions.
   *
   * @return array
   *   Array of suggestions.
   */
  public function &getSuggestions(): array {
    return $this->suggestions;
  }

  /**
   * Get variables.
   *
   * @return array
   *   Array of variables.
   */
  public function getVariables(): array {
    return $this->variables;
  }

  /**
   * Get hook.
   *
   * @return string
   *   Name of the hook.
   */
  public function getHook(): string {
    return $this->hook;
  }

}
