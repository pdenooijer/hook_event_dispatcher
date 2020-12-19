<?php

namespace Drupal\Tests\user_event_dispatcher\Unit\User;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Session\AccountInterface;
use Drupal\user_event_dispatcher\Event\User\UserCancelMethodsAlterEvent;
use Drupal\user_event_dispatcher\Event\User\UserFormatNameAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function user_event_dispatcher_user_cancel;
use function user_event_dispatcher_user_cancel_methods_alter;
use function user_event_dispatcher_user_format_name_alter;
use function user_event_dispatcher_user_login;
use function user_event_dispatcher_user_logout;

/**
 * Class UserEventTest.
 *
 * @group user_event_dispatcher
 */
class UserEventTest extends TestCase {

  /**
   * The manager.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy
   */
  private $manager;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    Drupal::setContainer($builder);
  }

  /**
   * User cancel event test.
   */
  public function testUserCancelEvent(): void {
    $edit = ['Test', 'array'];
    /** @var \Drupal\Core\Session\AccountInterface $account */
    $account = $this->createMock(AccountInterface::class);
    $method = 'Test method';

    user_event_dispatcher_user_cancel($edit, $account, $method);

    /** @var \Drupal\user_event_dispatcher\Event\User\UserCancelEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::USER_CANCEL);
    self::assertSame($edit, $event->getEdit());
    self::assertSame($account, $event->getAccount());
    self::assertSame($method, $event->getMethod());
  }

  /**
   * User cancel methods alter event test.
   *
   * @SuppressWarnings(PHPMD.UnusedLocalVariable)
   */
  public function testUserCancelMethodsAlterEvent(): void {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::USER_CANCEL_METHODS_ALTER => static function (UserCancelMethodsAlterEvent $event) {
        $name = &$event->getMethods()[0];
        $name .= ' improved!';
      },
    ]);

    $methods = ['Test method'];
    $expectedMethods = ['Test method improved!'];

    user_event_dispatcher_user_cancel_methods_alter($methods);

    /** @var \Drupal\user_event_dispatcher\Event\User\UserCancelMethodsAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::USER_CANCEL_METHODS_ALTER);
    self::assertSame($expectedMethods, $methods);
    self::assertSame($expectedMethods, $event->getMethods());
  }

  /**
   * User login event test.
   */
  public function testUserLoginEvent(): void {
    /** @var \Drupal\Core\Session\AccountInterface $account */
    $account = $this->createMock(AccountInterface::class);

    user_event_dispatcher_user_login($account);

    /** @var \Drupal\user_event_dispatcher\Event\User\UserLoginEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::USER_LOGIN);
    self::assertEquals($account, $event->getAccount());
  }

  /**
   * User logout event test.
   */
  public function testUserLogoutEvent(): void {
    /** @var \Drupal\Core\Session\AccountInterface $account */
    $account = $this->createMock(AccountInterface::class);

    user_event_dispatcher_user_logout($account);

    /** @var \Drupal\user_event_dispatcher\Event\User\UserLogoutEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::USER_LOGOUT);
    self::assertEquals($account, $event->getAccount());
  }

  /**
   * User format name alter event test.
   */
  public function testUserFormatNameAlterEvent(): void {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::USER_FORMAT_NAME_ALTER => static function (UserFormatNameAlterEvent $event) {
        $name = &$event->getName();
        $name .= ' improved!';
      },
    ]);

    $name = 'Test name';
    /** @var \Drupal\Core\Session\AccountInterface $account */
    $account = $this->createMock(AccountInterface::class);

    user_event_dispatcher_user_format_name_alter($name, $account);

    /** @var \Drupal\user_event_dispatcher\Event\User\UserFormatNameAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::USER_FORMAT_NAME_ALTER);
    self::assertSame('Test name improved!', $event->getName());
    self::assertSame($account, $event->getAccount());
  }

}
