<?php

namespace Drupal\views_event_dispatcher\Event\Views;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class ViewsQuerySubstitutionEvent.
 */
final class ViewsQuerySubstitutionsEvent extends AbstractViewsEvent {

  /**
   * Views query substitutions.
   *
   * @var array
   */
  private $substitutions = [];

  /**
   * Get the query substitutions.
   *
   * @return array
   *   An associative array where each key is a string to be replaced, and the
   *   corresponding value is its replacement. The strings to replace are often
   *   surrounded with '***', as illustrated in the example implementation, to
   *   avoid collisions with other values in the query.
   */
  public function &getSubstitutions(): array {
    return $this->substitutions;
  }

  /**
   * Add a substitution.
   *
   * @param string $target
   *   String target to be replaced.
   * @param string $replacement
   *   The replacement of the given target.
   */
  public function addSubstitution(string $target, string $replacement): void {
    $this->substitutions[$target] = $replacement;
  }

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::VIEWS_QUERY_SUBSTITUTIONS;
  }

}
