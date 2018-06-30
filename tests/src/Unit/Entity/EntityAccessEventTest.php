<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Entity;

use Drupal\Core\Access\AccessResultAllowed;
use Drupal\Core\Access\AccessResultForbidden;
use Drupal\Core\Access\AccessResultNeutral;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\hook_event_dispatcher\Event\Entity\EntityAccessEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class EntityAccessEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Entity
 *
 * @group hook_event_dispatcher
 */
class EntityAccessEventTest extends UnitTestCase {

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
   * Deprecated setEntity method test.
   *
   * @deprecated should be removed when setEntity() method is removed.
   */
  public function testDeprecatedSetEntityMethod() {
    $entity = $this->createMock(EntityInterface::class);
    $operation = 'test';
    $account = $this->createMock(AccountInterface::class);
    $event = new EntityAccessEvent($entity, $operation, $account);

    $otherEntity = $this->createMock(EntityInterface::class);
    $event->setEntity($otherEntity);

    $this->assertEquals($otherEntity, $event->getEntity());
  }

  /**
   * EntityAccessEvent with no changes test.
   */
  public function testEntityAccessEventWithNoChanges() {
    $entity = $this->createMock(EntityInterface::class);
    $operation = 'test';
    $account = $this->createMock(AccountInterface::class);

    $hookAccessResult = hook_event_dispatcher_entity_access($entity, $operation, $account);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityAccessEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_ACCESS);
    $this->assertSame($entity, $event->getEntity());
    $this->assertSame($operation, $event->getOperation());
    $this->assertSame($account, $event->getAccount());

    $this->assertTrue($hookAccessResult->isNeutral());
    $this->assertFalse($hookAccessResult->isAllowed());
    $this->assertFalse($hookAccessResult->isForbidden());
  }

  /**
   * EntityAccessEvent with deprecated setAccessResult test.
   *
   * @deprecated should be removed when setAccessResult method is removed.
   */
  public function testEntityAccessEventWithDeprecatedSetAccessResult() {
    $accessResult = new AccessResultForbidden();
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_ACCESS => function (EntityAccessEvent $event) use ($accessResult) {
        $event->setAccessResult($accessResult);
      },
    ]);

    $entity = $this->createMock(EntityInterface::class);
    $operation = 'test';
    $account = $this->createMock(AccountInterface::class);

    $hookAccessResult = hook_event_dispatcher_entity_access($entity, $operation, $account);

    $this->assertFalse($hookAccessResult->isNeutral());
    $this->assertFalse($hookAccessResult->isAllowed());
    $this->assertTrue($hookAccessResult->isForbidden());
  }

  /**
   * EntityAccessEvent with neutral result test.
   */
  public function testEntityAccessEventNeutralResult() {
    $accessResult = new AccessResultNeutral();
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_ACCESS => function (EntityAccessEvent $event) use ($accessResult) {
        $event->addAccessResult($accessResult);
      },
    ]);

    $entity = $this->createMock(EntityInterface::class);
    $operation = 'test';
    $account = $this->createMock(AccountInterface::class);

    $hookAccessResult = hook_event_dispatcher_entity_access($entity, $operation, $account);

    $this->assertTrue($hookAccessResult->isNeutral());
    $this->assertFalse($hookAccessResult->isAllowed());
    $this->assertFalse($hookAccessResult->isForbidden());
  }

  /**
   * EntityAccessEvent with allowed result test.
   */
  public function testEntityAccessEventAllowedResult() {
    $accessResult = new AccessResultAllowed();
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_ACCESS => function (EntityAccessEvent $event) use ($accessResult) {
        $event->addAccessResult($accessResult);
      },
    ]);

    $entity = $this->createMock(EntityInterface::class);
    $operation = 'test';
    $account = $this->createMock(AccountInterface::class);

    $hookAccessResult = hook_event_dispatcher_entity_access($entity, $operation, $account);

    $this->assertFalse($hookAccessResult->isNeutral());
    $this->assertTrue($hookAccessResult->isAllowed());
    $this->assertFalse($hookAccessResult->isForbidden());
  }

  /**
   * EntityAccessEvent with forbidden result test.
   */
  public function testEntityAccessEventForbiddenResult() {
    $accessResult = new AccessResultForbidden();
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_ACCESS => function (EntityAccessEvent $event) use ($accessResult) {
        $event->addAccessResult($accessResult);
      },
    ]);

    $entity = $this->createMock(EntityInterface::class);
    $operation = 'test';
    $account = $this->createMock(AccountInterface::class);

    $hookAccessResult = hook_event_dispatcher_entity_access($entity, $operation, $account);

    $this->assertFalse($hookAccessResult->isNeutral());
    $this->assertFalse($hookAccessResult->isAllowed());
    $this->assertTrue($hookAccessResult->isForbidden());
  }

  /**
   * EntityAccessEvent with combined results test.
   *
   * This simulates multiple event listeners adding their own access results to
   * this event.
   */
  public function testEntityAccessEventCombinedResults() {
    $accessResults = [
      new AccessResultNeutral(),
      new AccessResultAllowed(),
      new AccessResultForbidden(),
    ];
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_ACCESS => function (EntityAccessEvent $event) use ($accessResults) {
        foreach ($accessResults as $accessResult) {
          $event->addAccessResult($accessResult);
        }
      },
    ]);

    $entity = $this->createMock(EntityInterface::class);
    $operation = 'test';
    $account = $this->createMock(AccountInterface::class);

    $hookAccessResult = hook_event_dispatcher_entity_access($entity, $operation, $account);

    $this->assertFalse($hookAccessResult->isNeutral());
    $this->assertFalse($hookAccessResult->isAllowed());
    $this->assertTrue($hookAccessResult->isForbidden());
  }

}
