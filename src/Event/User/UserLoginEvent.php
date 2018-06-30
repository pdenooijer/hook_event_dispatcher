<?php

namespace Drupal\hook_event_dispatcher\Event\User;

use Drupal\Core\Session\AccountInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class UserLoginEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\User
 */
final class UserLoginEvent extends Event implements EventInterface {

  /**
   * Account.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  private $account;

  /**
   * UserLoginEvent constructor.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Account.
   */
  public function __construct(AccountInterface $account) {
    $this->account = $account;
  }

  /**
   * Get the account.
   *
   * @return \Drupal\Core\Session\AccountInterface
   *   Account.
   */
  public function getAccount() {
    return $this->account;
  }

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::USER_LOGIN;
  }

}
