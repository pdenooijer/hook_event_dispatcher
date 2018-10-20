<?php

namespace Drupal\hook_event_dispatcher\Event\Theme;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class BaseThemeSuggestionsEvent.
 */
abstract class BaseThemeSuggestionsEvent extends Event implements EventInterface {

  /**
   * Array of suggestions.
   *
   * @var array
   */
  protected $suggestions;

  /**
   * Variables.
   *
   * @var array
   */
  protected $variables;

  /**
   * Hook name.
   *
   * @var string
   */
  protected $hook;

  /**
   * BaseThemeSuggestionsEvent constructor.
   *
   * @param array $suggestions
   *   Suggestions.
   * @param array $variables
   *   Variables.
   * @param string $hook
   *   Hook name.
   */
  public function __construct(array &$suggestions, array $variables, $hook) {
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
  public function &getSuggestions() {
    return $this->suggestions;
  }

  /**
   * Set suggestions.
   *
   * @param array $suggestions
   *   Array of suggestions.
   */
  public function setSuggestions(array $suggestions) {
    $this->suggestions = $suggestions;
  }

  /**
   * Get variables.
   *
   * @return array
   *   Array of variables.
   */
  public function getVariables() {
    return $this->variables;
  }

  /**
   * Get hook.
   *
   * @return string
   *   Name of the hook.
   */
  public function getHook() {
    return $this->hook;
  }

}
