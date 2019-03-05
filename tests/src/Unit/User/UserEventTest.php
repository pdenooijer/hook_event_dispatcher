<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\User;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Session\AccountInterface;
use Drupal\hook_event_dispatcher\Event\User\UserCancelMethodsAlterEvent;
use Drupal\hook_event_dispatcher\Event\User\UserFormatNameAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class UserEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\User
 *
 * @group hook_event_dispatcher
 */
class UserEventTest extends UnitTestCase {

  /**
   * The manager.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy
   */
  private $manager;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    \Drupal::setContainer($builder);
  }

  /**
   * User cancel event test.
   */
  public function testUserCancelEvent() {
    $edit = ['Test', 'array'];
    /* @var \Drupal\Core\Session\AccountInterface $account */
    $account = $this->createMock(AccountInterface::class);
    $method = 'Test method';

    hook_event_dispatcher_user_cancel($edit, $account, $method);

    /* @var \Drupal\hook_event_dispatcher\Event\User\UserCancelEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::USER_CANCEL);
    $this->assertSame($edit, $event->getEdit());
    $this->assertSame($account, $event->getAccount());
    $this->assertSame($method, $event->getMethod());
  }

  /**
   * User cancel methods alter event by reference test.
   */
  public function testUserCancelMethodsAlterEventByReference() {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::USER_CANCEL_METHODS_ALTER => function (UserCancelMethodsAlterEvent $event) {
        $name = &$event->getMethods()[0];
        $name .= ' improved!';
      },
    ]);

    $methods = ['Test method'];

    hook_event_dispatcher_user_cancel_methods_alter($methods);

    /* @var \Drupal\hook_event_dispatcher\Event\User\UserCancelMethodsAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::USER_CANCEL_METHODS_ALTER);
    $this->assertSame(['Test method improved!'], $event->getMethods());
  }

  /**
   * User cancel methods alter event with set test.
   */
  public function testUserCancelMethodsAlterEventWithSet() {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::USER_CANCEL_METHODS_ALTER => function (UserCancelMethodsAlterEvent $event) {
        $event->setMethods(['New method']);
      },
    ]);

    $methods = ['Test method'];

    hook_event_dispatcher_user_cancel_methods_alter($methods);

    /* @var \Drupal\hook_event_dispatcher\Event\User\UserCancelMethodsAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::USER_CANCEL_METHODS_ALTER);
    $this->assertSame(['New method'], $event->getMethods());
  }

  /**
   * User login event test.
   */
  public function testUserLoginEvent() {
    /** @var \Drupal\Core\Session\AccountInterface $account */
    $account = $this->createMock(AccountInterface::class);

    hook_event_dispatcher_user_login($account);

    /* @var \Drupal\hook_event_dispatcher\Event\User\UserLoginEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::USER_LOGIN);
    $this->assertEquals($account, $event->getAccount());
  }

  /**
   * User logout event test.
   */
  public function testUserLogoutEvent() {
    /** @var \Drupal\Core\Session\AccountInterface $account */
    $account = $this->createMock(AccountInterface::class);

    hook_event_dispatcher_user_logout($account);

    /* @var \Drupal\hook_event_dispatcher\Event\User\UserLogoutEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::USER_LOGOUT);
    $this->assertEquals($account, $event->getAccount());
  }

  /**
   * User format name alter event by reference test.
   */
  public function testUserFormatNameAlterEventByReference() {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::USER_FORMAT_NAME_ALTER => function (UserFormatNameAlterEvent $event) {
        $name = &$event->getName();
        $name .= ' improved!';
      },
    ]);

    $name = 'Test name';
    /** @var \Drupal\Core\Session\AccountInterface $account */
    $account = $this->createMock(AccountInterface::class);

    hook_event_dispatcher_user_format_name_alter($name, $account);

    /* @var \Drupal\hook_event_dispatcher\Event\User\UserFormatNameAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::USER_FORMAT_NAME_ALTER);
    $this->assertSame('Test name improved!', $event->getName());
    $this->assertSame($account, $event->getAccount());
  }

  /**
   * User format name alter event with set test.
   */
  public function testUserFormatNameAlterEventWithSet() {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::USER_FORMAT_NAME_ALTER => function (UserFormatNameAlterEvent $event) {
        $event->setName('New name!');
      },
    ]);

    $name = 'Test name';
    /** @var \Drupal\Core\Session\AccountInterface $account */
    $account = $this->createMock(AccountInterface::class);

    hook_event_dispatcher_user_format_name_alter($name, $account);

    /* @var \Drupal\hook_event_dispatcher\Event\User\UserFormatNameAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::USER_FORMAT_NAME_ALTER);
    $this->assertSame('New name!', $event->getName());
    $this->assertSame($account, $event->getAccount());
  }

}
