<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Entity;

use Drupal;
use Drupal\Core\Access\AccessResultAllowed;
use Drupal\Core\Access\AccessResultForbidden;
use Drupal\Core\Access\AccessResultNeutral;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\core_event_dispatcher\Event\Entity\EntityAccessEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function core_event_dispatcher_entity_access;

/**
 * Class EntityAccessEventTest.
 *
 * @group core_event_dispatcher
 */
class EntityAccessEventTest extends TestCase {

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
   * EntityAccessEvent with no changes test.
   */
  public function testEntityAccessEventWithNoChanges(): void {
    $entity = $this->createMock(EntityInterface::class);
    $operation = 'test';
    $account = $this->createMock(AccountInterface::class);

    $hookAccessResult = core_event_dispatcher_entity_access($entity, $operation, $account);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityAccessEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_ACCESS);
    self::assertSame($entity, $event->getEntity());
    self::assertSame($operation, $event->getOperation());
    self::assertSame($account, $event->getAccount());

    self::assertTrue($hookAccessResult->isNeutral());
    self::assertFalse($hookAccessResult->isAllowed());
    self::assertFalse($hookAccessResult->isForbidden());
  }

  /**
   * EntityAccessEvent with neutral result test.
   */
  public function testEntityAccessEventNeutralResult(): void {
    $accessResult = new AccessResultNeutral();
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_ACCESS => static function (EntityAccessEvent $event) use ($accessResult) {
        $event->addAccessResult($accessResult);
      },
    ]);

    $entity = $this->createMock(EntityInterface::class);
    $operation = 'test';
    $account = $this->createMock(AccountInterface::class);

    $hookAccessResult = core_event_dispatcher_entity_access($entity, $operation, $account);

    self::assertTrue($hookAccessResult->isNeutral());
    self::assertFalse($hookAccessResult->isAllowed());
    self::assertFalse($hookAccessResult->isForbidden());
  }

  /**
   * EntityAccessEvent with allowed result test.
   */
  public function testEntityAccessEventAllowedResult(): void {
    $accessResult = new AccessResultAllowed();
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_ACCESS => static function (EntityAccessEvent $event) use ($accessResult) {
        $event->addAccessResult($accessResult);
      },
    ]);

    $entity = $this->createMock(EntityInterface::class);
    $operation = 'test';
    $account = $this->createMock(AccountInterface::class);

    $hookAccessResult = core_event_dispatcher_entity_access($entity, $operation, $account);

    self::assertFalse($hookAccessResult->isNeutral());
    self::assertTrue($hookAccessResult->isAllowed());
    self::assertFalse($hookAccessResult->isForbidden());
  }

  /**
   * EntityAccessEvent with forbidden result test.
   */
  public function testEntityAccessEventForbiddenResult(): void {
    $accessResult = new AccessResultForbidden();
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_ACCESS => static function (EntityAccessEvent $event) use ($accessResult) {
        $event->addAccessResult($accessResult);
      },
    ]);

    $entity = $this->createMock(EntityInterface::class);
    $operation = 'test';
    $account = $this->createMock(AccountInterface::class);

    $hookAccessResult = core_event_dispatcher_entity_access($entity, $operation, $account);

    self::assertFalse($hookAccessResult->isNeutral());
    self::assertFalse($hookAccessResult->isAllowed());
    self::assertTrue($hookAccessResult->isForbidden());
  }

  /**
   * EntityAccessEvent with combined results test.
   *
   * This simulates multiple event listeners adding their own access results to
   * this event.
   */
  public function testEntityAccessEventCombinedResults(): void {
    $accessResults = [
      new AccessResultNeutral(),
      new AccessResultAllowed(),
      new AccessResultForbidden(),
    ];
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_ACCESS => static function (EntityAccessEvent $event) use ($accessResults) {
        foreach ($accessResults as $accessResult) {
          $event->addAccessResult($accessResult);
        }
      },
    ]);

    $entity = $this->createMock(EntityInterface::class);
    $operation = 'test';
    $account = $this->createMock(AccountInterface::class);

    $hookAccessResult = core_event_dispatcher_entity_access($entity, $operation, $account);

    self::assertFalse($hookAccessResult->isNeutral());
    self::assertFalse($hookAccessResult->isAllowed());
    self::assertTrue($hookAccessResult->isForbidden());
  }

}
