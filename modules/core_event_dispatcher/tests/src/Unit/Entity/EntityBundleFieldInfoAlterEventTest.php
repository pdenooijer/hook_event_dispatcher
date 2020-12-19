<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Entity;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\core_event_dispatcher\Event\Entity\EntityBundleFieldInfoAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function core_event_dispatcher_entity_bundle_field_info_alter;

/**
 * Class EntityBundleFieldInfoAlterEventTest.
 *
 * @group core_event_dispatcher
 */
class EntityBundleFieldInfoAlterEventTest extends TestCase {

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
   * Test the EntityBundleFieldInfoAlterEventTest.
   */
  public function testEntityBundleFieldInfoAlterEvent(): void {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_BUNDLE_FIELD_INFO_ALTER => static function (EntityBundleFieldInfoAlterEvent $event) {
        $fields = &$event->getFields();
        $fields['field_test'] = 'test_altered';
      },
    ]);

    $fields = $expectedFields = [
      'field_test' => 'test',
    ];
    $entityType = $this->createMock(EntityTypeInterface::class);
    $bundle = 'test_bundle';
    core_event_dispatcher_entity_bundle_field_info_alter($fields, $entityType, $bundle);

    $expectedFields['field_test'] = 'test_altered';
    self::assertSame($expectedFields, $fields);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityBundleFieldInfoAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_BUNDLE_FIELD_INFO_ALTER);
    self::assertSame($expectedFields, $event->getFields());
    self::assertSame($entityType, $event->getEntityType());
    self::assertSame($bundle, $event->getBundle());
  }

}
