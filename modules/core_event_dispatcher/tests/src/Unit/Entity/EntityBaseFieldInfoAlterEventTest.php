<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Entity;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\core_event_dispatcher\Event\Entity\EntityBaseFieldInfoAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function core_event_dispatcher_entity_base_field_info_alter;

/**
 * Class EntityBaseFieldInfoAlterEventTest.
 *
 * @group core_event_dispatcher
 */
class EntityBaseFieldInfoAlterEventTest extends TestCase {

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
   * Test the EntityBaseFieldInfoAlterEvent.
   */
  public function testEntityBaseFieldInfoAlterEvent(): void {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_BASE_FIELD_INFO_ALTER => static function (EntityBaseFieldInfoAlterEvent $event) {
        $fields = &$event->getFields();
        $fields['field_test'] = 'test_altered';
      },
    ]);

    $fields = $expectedFields = [
      'field_test' => 'test',
    ];
    $entityType = $this->createMock(EntityTypeInterface::class);
    core_event_dispatcher_entity_base_field_info_alter($fields, $entityType);

    $expectedFields['field_test'] = 'test_altered';
    self::assertSame($expectedFields, $fields);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityBaseFieldInfoAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_BASE_FIELD_INFO_ALTER);
    self::assertSame($expectedFields, $event->getFields());
    self::assertSame($entityType, $event->getEntityType());
  }

}
