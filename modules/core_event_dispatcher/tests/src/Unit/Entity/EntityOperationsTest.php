<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Entity;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\core_event_dispatcher\Event\Entity\EntityOperationAlterEvent;
use Drupal\core_event_dispatcher\Event\Entity\EntityOperationEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function core_event_dispatcher_entity_operation;
use function core_event_dispatcher_entity_operation_alter;

/**
 * Class EntityOperationsTest.
 *
 * @group core_event_dispatcher
 */
class EntityOperationsTest extends TestCase {

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
   * EntityOperationEvent test.
   */
  public function testEntityOperation(): void {
    $entity = $this->createMock(EntityInterface::class);

    $operations = [
      'test' => [
        'title' => 'new',
      ],
    ];
    $extraOperation = [
      'title' => 'extra',
    ];
    $expectedOperations = $operations + ['extra' => $extraOperation];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_OPERATION => static function (EntityOperationEvent $event) use ($operations, $extraOperation) {
        $event->setOperations($operations);
        $event->addOperation('extra', $extraOperation);
      },
    ]);

    $result = core_event_dispatcher_entity_operation($entity);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityOperationEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_OPERATION);
    self::assertSame($entity, $event->getEntity());
    self::assertSame($expectedOperations, $result);
  }

  /**
   * EntityOperationAlterEvent test.
   */
  public function testEntityOperationAlter(): void {
    $entity = $this->createMock(EntityInterface::class);
    $operations = [
      'my_opt' => [
        'title' => 'existing_ops',
      ],
    ];
    $extraOperation = ['title' => 'extra'];

    $expectedOperations = $operations + ['extra' => $extraOperation];
    $expectedOperations['my_opt']['title'] = 'changed!';

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_OPERATION_ALTER => static function (EntityOperationAlterEvent $event) use ($extraOperation) {
        $operations = &$event->getOperations();
        $operations['my_opt']['title'] = 'changed!';
        $operations['extra'] = $extraOperation;
      },
    ]);

    core_event_dispatcher_entity_operation_alter($operations, $entity);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityOperationAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_OPERATION_ALTER);
    self::assertSame($entity, $event->getEntity());
    self::assertSame($expectedOperations, $event->getOperations());
    self::assertSame($expectedOperations, $operations);
  }

}
