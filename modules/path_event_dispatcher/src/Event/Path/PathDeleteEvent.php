<?php

namespace Drupal\path_event_dispatcher\Event\Path;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class PathDeleteEvent.
 */
final class PathDeleteEvent extends AbstractPathEvent {

  /**
   * The redirect.
   *
   * @var bool
   */
  private $redirect;

  /**
   * Constructor.
   *
   * @param array $path
   *   The array structure is identical to that of the return value of
   *   \Drupal\Core\Path\AliasStorageInterface::save().
   */
  public function __construct(array $path) {
    parent::__construct($path);
    $this->redirect = $path['redirect'] ?? FALSE;
  }

  /**
   * Getter.
   *
   * @return bool
   *   If it's a redirect.
   */
  public function isRedirect(): bool {
    return $this->redirect;
  }

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::PATH_DELETE;
  }

}
