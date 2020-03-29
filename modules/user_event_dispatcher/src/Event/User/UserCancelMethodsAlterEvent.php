<?php

namespace Drupal\user_event_dispatcher\Event\User;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class UserFormatNameAlterEvent.
 */
final class UserCancelMethodsAlterEvent extends Event implements EventInterface {

  /**
   * Array containing user account cancellation methods, keyed by method id.
   *
   * @var array
   */
  private $methods;

  /**
   * UserCancelMethodsAlterEvent constructor.
   *
   * @param array $methods
   *   Array containing user account cancellation methods, keyed by method id.
   */
  public function __construct(array &$methods) {
    $this->methods = &$methods;
  }

  /**
   * Get methods by reference.
   *
   * @return array
   *   Methods.
   */
  public function &getMethods(): array {
    return $this->methods;
  }

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::USER_CANCEL_METHODS_ALTER;
  }

}
