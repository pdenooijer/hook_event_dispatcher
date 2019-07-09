<?php

namespace Drupal\hook_event_dispatcher\Event\Views;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class ViewsQuerySubstitutionEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Views
 */
final class ViewsQuerySubstitutionsEvent extends BaseViewsEvent {

  /**
   * Views query substitutions.
   *
   * @var array
   */
  private $substitutions = [];

  /**
   * Set the query substitutions.
   *
   * @param array $substitutions
   *   An associative array where each key is a string to be replaced, and the
   *   corresponding value is its replacement. The strings to replace are often
   *   surrounded with '***', as illustrated in the example implementation, to
   *   avoid collisions with other values in the query.
   */
  public function setSubstitutions(array $substitutions) {
    $this->substitutions = $substitutions;
  }

  /**
   * Get the query substitutions.
   *
   * @return array
   *   An associative array where each key is a string to be replaced, and the
   *   corresponding value is its replacement. The strings to replace are often
   *   surrounded with '***', as illustrated in the example implementation, to
   *   avoid collisions with other values in the query.
   */
  public function &getSubstitutions() {
    return $this->substitutions;
  }

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::VIEWS_QUERY_SUBSTITUTIONS;
  }

}
