<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\EntityType;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\hook_event_dispatcher\Event\EntityType\EntityTypeAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class EntityTypeAlterEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\EntityType
 *
 * @group hook_event_dispatcher
 */
class EntityTypeAlterEventTest extends UnitTestCase {

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
   * Test the EntityTypeAlterEvent.
   */
  public function testEntityTypeAlterEvent() {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_TYPE_ALTER => static function (EntityTypeAlterEvent $event) {
        $entityTypes = &$event->getEntityTypes();
        $entityTypes['my_custom_entity']->set('admin_permission', 'my custom permission');
      },
    ]);

    $entityType = $this->createMock(EntityTypeInterface::class);
    $entityType->expects($this->once())
      ->method('set')
      ->with($this->equalTo('admin_permission'), $this->equalTo('my custom permission'));
    $entityTypes = [
      'my_custom_entity' => $entityType,
    ];
    hook_event_dispatcher_entity_type_alter($entityTypes);

    /** @var \Drupal\hook_event_dispatcher\Event\EntityType\EntityTypeBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_TYPE_ALTER);

    $this->assertSame($entityTypes, $event->getEntityTypes());
  }

}
