<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Entity;

use Drupal;
use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\core_event_dispatcher\Event\Entity\EntityFieldAccessEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function core_event_dispatcher_entity_field_access;

/**
 * Class EntityFieldAccessEventTest.
 *
 * @group core_event_dispatcher
 */
class EntityFieldAccessEventTest extends TestCase {

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

    $hookAccessResult = core_event_dispatcher_entity_field_access($operation, $fieldDefinition, $account, $items);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityFieldAccessEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_FIELD_ACCESS);
    self::assertSame($operation, $event->getOperation());
    self::assertSame($fieldDefinition, $event->getFieldDefinition());
    self::assertSame($account, $event->getAccount());
    self::assertSame($items, $event->getItems());
    self::assertSame($hookAccessResult, $event->getAccessResult());
    self::assertTrue($event->getAccessResult()->isNeutral());
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

    $hookAccessResult = core_event_dispatcher_entity_field_access($operation, $fieldDefinition, $account, $items);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityFieldAccessEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_FIELD_ACCESS);
    self::assertSame($operation, $event->getOperation());
    self::assertSame($fieldDefinition, $event->getFieldDefinition());
    self::assertSame($account, $event->getAccount());
    self::assertSame($items, $event->getItems());
    self::assertSame($accessResult, $event->getAccessResult());
    self::assertSame($accessResult, $hookAccessResult);
  }

}
