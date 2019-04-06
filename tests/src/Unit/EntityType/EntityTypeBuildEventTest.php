<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\EntityType;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\hook_event_dispatcher\Event\EntityType\EntityTypeBuildEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class EntityTypeBuildEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\EntityType
 *
 * @group hook_event_dispatcher
 */
class EntityTypeBuildEventTest extends UnitTestCase {

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
   * Test the EntityTypeBuildEvent.
   */
  public function testEntityTypeBuildEvent() {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_TYPE_BUILD => static function (EntityTypeBuildEvent $event) {
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
    hook_event_dispatcher_entity_type_build($entityTypes);

    /** @var \Drupal\hook_event_dispatcher\Event\EntityType\EntityTypeBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_TYPE_BUILD);

    $this->assertEquals($entityTypes, $event->getEntityTypes());
  }

}
