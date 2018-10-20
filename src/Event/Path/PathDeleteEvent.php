<?php

namespace Drupal\hook_event_dispatcher\Event\Path;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class PathDeleteEvent.
 */
final class PathDeleteEvent extends BasePathEvent {

  /**
   * The redirect.
   *
   * @var bool
   */
  private $redirect;

  /**
   * Constructor.
   *
   * @param array $fields
   *   The raw database path fields.
   */
  public function __construct(array $fields) {
    parent::__construct($fields);
    $this->redirect = isset($fields['redirect']) ? $fields['redirect'] : NULL;
  }

  /**
   * Getter.
   *
   * @return bool
   *   If it's a redirect.
   */
  public function isRedirect() {
    return $this->redirect === TRUE;
  }

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::PATH_DELETE;
  }

}
