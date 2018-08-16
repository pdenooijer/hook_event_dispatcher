<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\EntityType;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\hook_event_dispatcher\Event\EntityType\EntityBundleFieldInfoAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class EntityBundleFieldInfoAlterEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\EntityType
 *
 * @group hook_event_dispatcher
 */
class EntityBundleFieldInfoAlterEventTest extends UnitTestCase {

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
   * Test the EntityBundleFieldInfoAlterEventTest.
   */
  public function testEntityBundleFieldInfoAlterEvent() {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_BUNDLE_FIELD_INFO_ALTER => function (EntityBundleFieldInfoAlterEvent $event) {
        $fields = &$event->getFields();
        $fields['field_test'] = 'test_altered';
      },
    ]);

    $fields = $expectedFields = [
      'field_test' => 'test',
    ];
    $entityType = $this->createMock(EntityTypeInterface::class);
    $bundle = 'test_bundle';
    hook_event_dispatcher_entity_bundle_field_info_alter($fields, $entityType, $bundle);

    $expectedFields['field_test'] = 'test_altered';
    $this->assertEquals($fields, $expectedFields);

    /** @var \Drupal\hook_event_dispatcher\Event\EntityType\EntityBundleFieldInfoAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_BUNDLE_FIELD_INFO_ALTER);

    $this->assertEquals($entityType, $event->getEntityType());
    $this->assertEquals($bundle, $event->getBundle());
  }

}
