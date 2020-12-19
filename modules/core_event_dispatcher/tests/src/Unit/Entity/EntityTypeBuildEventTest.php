<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Entity;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\core_event_dispatcher\Event\Entity\EntityTypeBuildEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function core_event_dispatcher_entity_type_build;

/**
 * Class EntityTypeBuildEventTest.
 *
 * @group core_event_dispatcher
 */
class EntityTypeBuildEventTest extends TestCase {

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
   * Test the EntityTypeBuildEvent.
   */
  public function testEntityTypeBuildEvent(): void {
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
    core_event_dispatcher_entity_type_build($entityTypes);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityTypeBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_TYPE_BUILD);
    self::assertSame($entityTypes, $event->getEntityTypes());
  }

}
