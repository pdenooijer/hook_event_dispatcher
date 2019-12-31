<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\EntityField;

use Drupal;
use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\hook_event_dispatcher\Event\EntityField\EntityFieldAccessEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;
use function hook_event_dispatcher_entity_field_access;

/**
 * Class EntityFieldAccessEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\EntityField
 *
 * @group hook_event_dispatcher
 */
class EntityFieldAccessEventTest extends UnitTestCase {

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
   * Field access event with result set.
   */
  public function testEntityFieldAccessEventWithoutResult(): void {
    $operation = 'test';
    $fieldDefinition = $this->createMock(FieldDefinitionInterface::class);
    $account = $this->createMock(AccountInterface::class);
    $items = $this->createMock(FieldItemListInterface::class);

    $hookAccessResult = hook_event_dispatcher_entity_field_access($operation, $fieldDefinition, $account, $items);

    /* @var \Drupal\hook_event_dispatcher\Event\EntityField\EntityFieldAccessEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_FIELD_ACCESS);
    $this->assertSame($operation, $event->getOperation());
    $this->assertSame($fieldDefinition, $event->getFieldDefinition());
    $this->assertSame($account, $event->getAccount());
    $this->assertSame($items, $event->getItems());
    $this->assertSame($hookAccessResult, $event->getAccessResult());
    $this->assertTrue($event->getAccessResult()->isNeutral());
  }

  /**
   * Field access event with result set.
   */
  public function testEntityFieldAccessEventWithResultSet(): void {
    $accessResult = $this->createMock(AccessResultInterface::class);
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_FIELD_ACCESS => static function (EntityFieldAccessEvent $event) use ($accessResult) {
        $event->setAccessResult($accessResult);
      },
    ]);

    $operation = 'test';
    $fieldDefinition = $this->createMock(FieldDefinitionInterface::class);
    $account = $this->createMock(AccountInterface::class);
    $items = $this->createMock(FieldItemListInterface::class);

    $hookAccessResult = hook_event_dispatcher_entity_field_access($operation, $fieldDefinition, $account, $items);

    /* @var \Drupal\hook_event_dispatcher\Event\EntityField\EntityFieldAccessEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_FIELD_ACCESS);
    $this->assertSame($operation, $event->getOperation());
    $this->assertSame($fieldDefinition, $event->getFieldDefinition());
    $this->assertSame($account, $event->getAccount());
    $this->assertSame($items, $event->getItems());
    $this->assertSame($accessResult, $event->getAccessResult());
    $this->assertSame($accessResult, $hookAccessResult);
  }

}
