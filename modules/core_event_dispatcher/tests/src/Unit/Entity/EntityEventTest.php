<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Entity;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function core_event_dispatcher_entity_create;
use function core_event_dispatcher_entity_delete;
use function core_event_dispatcher_entity_insert;
use function core_event_dispatcher_entity_load;
use function core_event_dispatcher_entity_predelete;
use function core_event_dispatcher_entity_presave;
use function core_event_dispatcher_entity_translation_delete;
use function core_event_dispatcher_entity_translation_insert;
use function core_event_dispatcher_entity_update;

/**
 * Class EntityEventTest.
 *
 * @group core_event_dispatcher
 */
class EntityEventTest extends TestCase {

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
   * Test EntityCreateEvent.
   */
  public function testEntityCreateEvent(): void {
    $entity = $this->createMock(EntityInterface::class);

    core_event_dispatcher_entity_create($entity);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityCreateEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_CREATE);
    self::assertSame($entity, $event->getEntity());
  }

  /**
   * Test EntityDeleteEvent.
   */
  public function testEntityDeleteEvent(): void {
    $entity = $this->createMock(EntityInterface::class);

    core_event_dispatcher_entity_delete($entity);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityDeleteEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_DELETE);
    self::assertSame($entity, $event->getEntity());
  }

  /**
   * Test EntityInsertEvent.
   */
  public function testEntityInsertEvent(): void {
    $entity = $this->createMock(EntityInterface::class);

    core_event_dispatcher_entity_insert($entity);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityInsertEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_INSERT);
    self::assertSame($entity, $event->getEntity());
  }

  /**
   * Test EntityLoadEvent.
   */
  public function testEntityLoadEvent(): void {
    $entities = [
      $this->createMock(EntityInterface::class),
      $this->createMock(EntityInterface::class),
      $this->createMock(EntityInterface::class),
    ];
    $entityTypeId = 'test';

    core_event_dispatcher_entity_load($entities, $entityTypeId);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityLoadEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_LOAD);
    self::assertSame($entities, $event->getEntities());
    self::assertSame($entityTypeId, $event->getEntityTypeId());
  }

  /**
   * Test EntityTranslationInsertEvent.
   */
  public function testEntityTranslationInsertEvent(): void {
    $entity = $this->createMock(EntityInterface::class);

    core_event_dispatcher_entity_translation_insert($entity);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityTranslationInsertEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_TRANSLATION_INSERT);
    self::assertSame($entity, $event->getEntity());
  }

  /**
   * Test EntityTranslationDeleteEvent.
   */
  public function testEntityTranslationDeleteEvent(): void {
    $entity = $this->createMock(EntityInterface::class);

    core_event_dispatcher_entity_translation_delete($entity);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityTranslationDeleteEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_TRANSLATION_DELETE);
    self::assertSame($entity, $event->getEntity());
  }

  /**
   * Test EntityPredeleteEvent.
   */
  public function testEntityPredeleteEvent(): void {
    $entity = $this->createMock(EntityInterface::class);

    core_event_dispatcher_entity_predelete($entity);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityPredeleteEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_PRE_DELETE);
    self::assertSame($entity, $event->getEntity());
  }

  /**
   * Test EntityPresaveEvent.
   */
  public function testEntityPresaveEvent(): void {
    $entity = $this->createMock(EntityInterface::class);
    $originalEntity = $this->createMock(EntityInterface::class);
    $entity->original = $originalEntity;

    core_event_dispatcher_entity_presave($entity);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityPresaveEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_PRE_SAVE);
    self::assertSame($entity, $event->getEntity());
    self::assertSame($originalEntity, $event->getOriginalEntity());
  }

  /**
   * Test EntityPresaveEvent without original.
   */
  public function testEntityPresaveEventWithoutOriginal(): void {
    $entity = $this->createMock(EntityInterface::class);

    core_event_dispatcher_entity_presave($entity);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityPresaveEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_PRE_SAVE);
    self::assertSame($entity, $event->getEntity());
    self::assertNull($event->getOriginalEntity());
  }

  /**
   * Test EntityUpdateEvent.
   */
  public function testEntityUpdateEvent(): void {
    $entity = $this->createMock(EntityInterface::class);
    $originalEntity = $this->createMock(EntityInterface::class);
    $entity->original = $originalEntity;

    core_event_dispatcher_entity_update($entity);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityUpdateEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_UPDATE);
    self::assertSame($entity, $event->getEntity());
    self::assertSame($originalEntity, $event->getOriginalEntity());
  }

}
