<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\EntityType;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;

/**
 * Class EntityTypeTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\EntityType
 *
 * @group hook_event_dispatcher
 */
class EntityTypeTest extends TestCase {

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
     * Test the EntityBaseFieldInfoEvent.
     */
    public function testEntityBaseFieldInfoEvent() {
        $entityType = $this->createMock(EntityTypeInterface::class);

        $fields = hook_event_dispatcher_entity_base_field_info($entityType);

        /* @var \Drupal\hook_event_dispatcher\Event\EntityType\EntityBaseFieldInfoEvent $event */
        $event = $this->manager->getRegisteredEvent(HookEventDispatcherEvents::ENTITY_BASE_FIELD_INFO);

        $this->assertEquals($entityType, $event->getEntityType());
        $this->assertEquals($fields, $event->getFields());
    }

}
