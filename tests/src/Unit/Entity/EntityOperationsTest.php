<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Entity;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\hook_event_dispatcher\Event\Entity\EntityOperationAlterEvent;
use Drupal\hook_event_dispatcher\Event\Entity\EntityOperationEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class EntityOperationsTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Entity
 *
 * @group hook_event_dispatcher
 */
class EntityOperationsTest extends UnitTestCase {

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
   * EntityOperationEvent test.
   */
  public function testEntityOperation() {
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

    $result = hook_event_dispatcher_entity_operation($entity);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityOperationEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_OPERATION);
    $this->assertSame($entity, $event->getEntity());
    $this->assertSame($expectedOperations, $result);
  }

  /**
   * EntityOperationAlterEvent test.
   */
  public function testEntityOperationAlter() {
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

    hook_event_dispatcher_entity_operation_alter($operations, $entity);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityOperationAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_OPERATION_ALTER);
    $this->assertSame($entity, $event->getEntity());
    $this->assertSame($expectedOperations, $event->getOperations());
    $this->assertSame($expectedOperations, $operations);
  }

}
