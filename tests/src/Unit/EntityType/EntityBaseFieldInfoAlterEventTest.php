<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\EntityType;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\hook_event_dispatcher\Event\EntityType\EntityBaseFieldInfoAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class EntityBaseFieldInfoAlterEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\EntityType
 *
 * @group hook_event_dispatcher
 */
class EntityBaseFieldInfoAlterEventTest extends UnitTestCase {

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
   * Test the EntityBaseFieldInfoAlterEvent.
   */
  public function testEntityBaseFieldInfoAlterEvent() {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_BASE_FIELD_INFO_ALTER => function (EntityBaseFieldInfoAlterEvent $event) {
        $fields = &$event->getFields();
        $fields['field_test'] = 'test_altered';
      },
    ]);

    $fields = $expectedFields = [
      'field_test' => 'test',
    ];
    $entityType = $this->createMock(EntityTypeInterface::class);
    hook_event_dispatcher_entity_base_field_info_alter($fields, $entityType);

    $expectedFields['field_test'] = 'test_altered';
    $this->assertEquals($fields, $expectedFields);

    /* @var \Drupal\hook_event_dispatcher\Event\EntityType\EntityBaseFieldInfoAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_BASE_FIELD_INFO_ALTER);
    $this->assertEquals($entityType, $event->getEntityType());
  }

}
