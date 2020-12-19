<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Entity;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\core_event_dispatcher\Event\Entity\EntityBaseFieldInfoEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function core_event_dispatcher_entity_base_field_info;

/**
 * Class EntityTypeTest.
 *
 * @group core_event_dispatcher
 */
class EntityTypeBaseFieldTest extends TestCase {

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
   * Test the EntityBaseFieldInfoEvent.
   */
  public function testEntityBaseFieldInfoEvent(): void {
    $fields = [
      'field_test1' => 'test',
      'field_test2' => 'otherTest',
    ];
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_BASE_FIELD_INFO => static function (EntityBaseFieldInfoEvent $event) use ($fields) {
        $event->setFields($fields);
      },
    ]);

    $entityType = $this->createMock(EntityTypeInterface::class);

    $hookFieldInfoResult = core_event_dispatcher_entity_base_field_info($entityType);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityBaseFieldInfoEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_BASE_FIELD_INFO);
    self::assertSame($entityType, $event->getEntityType());
    self::assertSame($fields, $event->getFields());
    self::assertSame($fields, $hookFieldInfoResult);
  }

}
