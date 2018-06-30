<?php

namespace Drupal\hook_event_dispatcher\Event\User;

use Drupal\Core\Session\AccountInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class UserFormatNameAlterEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\User
 */
final class UserFormatNameAlterEvent extends Event implements EventInterface {

  /**
   * Name.
   *
   * @var string
   */
  private $name;

  /**
   * Account.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  private $account;

  /**
   * UserFormatNameAlterEvent constructor.
   *
   * @param string|\Drupal\Component\Render\MarkupInterface $name
   *   Name.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Account.
   */
  public function __construct(&$name, AccountInterface $account) {
    $this->name = &$name;
    $this->account = $account;
  }

  /**
   * Get the name by reference.
   *
   * @return string
   *   Name.
   */
  public function &getName() {
    return $this->name;
  }

  /**
   * Set the new name.
   *
   * @param string $name
   *   Name.
   */
  public function setName($name) {
    $this->name = $name;
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
    return HookEventDispatcherInterface::USER_FORMAT_NAME_ALTER;
  }

}
