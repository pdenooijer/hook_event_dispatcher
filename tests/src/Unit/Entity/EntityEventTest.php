<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Entity;

use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\hook_event_dispatcher\Event\Entity\EntityAccessEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class EntityEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Entity
 *
 * @group hook_event_dispatcher
 */
class EntityEventTest extends UnitTestCase {

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
   * Test EntityCreateEvent.
   */
  public function testEntityCreateEvent() {
    $entity = $this->createMock(EntityInterface::class);

    hook_event_dispatcher_entity_create($entity);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityCreateEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_CREATE);
    $this->assertEquals($entity, $event->getEntity());
  }

  /**
   * Test EntityDeleteEvent.
   */
  public function testEntityDeleteEvent() {
    $entity = $this->createMock(EntityInterface::class);

    hook_event_dispatcher_entity_delete($entity);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityDeleteEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_DELETE);
    $this->assertEquals($entity, $event->getEntity());
  }

  /**
   * Test EntityInsertEvent.
   */
  public function testEntityInsertEvent() {
    $entity = $this->createMock(EntityInterface::class);

    hook_event_dispatcher_entity_insert($entity);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityInsertEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_INSERT);
    $this->assertEquals($entity, $event->getEntity());
  }

  /**
   * Test EntityLoadEvent.
   */
  public function testEntityLoadEvent() {
    $entities = [
      $this->createMock(EntityInterface::class),
      $this->createMock(EntityInterface::class),
      $this->createMock(EntityInterface::class),
    ];
    $entityTypeId = 'test';

    hook_event_dispatcher_entity_load($entities, $entityTypeId);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityLoadEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_LOAD);
    $this->assertEquals($entities, $event->getEntities());
    $this->assertEquals($entityTypeId, $event->getEntityTypeId());
  }

  /**
   * Test EntityTranslationInsertEvent.
   */
  public function testEntityTranslationInsertEvent() {
    $entity = $this->createMock(EntityInterface::class);

    hook_event_dispatcher_entity_translation_insert($entity);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityTranslationInsertEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_TRANSLATION_INSERT);
    $this->assertEquals($entity, $event->getEntity());
  }

  /**
   * Test EntityTranslationDeleteEvent.
   */
  public function testEntityTranslationDeleteEvent() {
    $entity = $this->createMock(EntityInterface::class);

    hook_event_dispatcher_entity_translation_delete($entity);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityTranslationDeleteEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_TRANSLATION_DELETE);
    $this->assertEquals($entity, $event->getEntity());
  }

  /**
   * Test EntityPredeleteEvent.
   */
  public function testEntityPredeleteEvent() {
    $entity = $this->createMock(EntityInterface::class);

    hook_event_dispatcher_entity_predelete($entity);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityPredeleteEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_PRE_DELETE);
    $this->assertEquals($entity, $event->getEntity());
  }

  /**
   * Test EntityPresaveEvent.
   */
  public function testEntityPresaveEvent() {
    $entity = $this->createMock(EntityInterface::class);
    $originalEntity = $this->createMock(EntityInterface::class);
    $entity->original = $originalEntity;

    hook_event_dispatcher_entity_presave($entity);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityPresaveEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_PRE_SAVE);
    $this->assertEquals($entity, $event->getEntity());
    $this->assertEquals($originalEntity, $event->getOriginalEntity());
  }

  /**
   * Test EntityUpdateEvent.
   */
  public function testEntityUpdateEvent() {
    $entity = $this->createMock(EntityInterface::class);
    $originalEntity = $this->createMock(EntityInterface::class);
    $entity->original = $originalEntity;

    hook_event_dispatcher_entity_update($entity);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityUpdateEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_UPDATE);
    $this->assertEquals($entity, $event->getEntity());
    $this->assertEquals($originalEntity, $event->getOriginalEntity());
  }

  /**
   * Test EntityViewEvent.
   */
  public function testEntityViewEvent() {
    $build = ['testBuild'];
    $entity = $this->createMock(EntityInterface::class);
    $display = $this->createMock(EntityViewDisplayInterface::class);
    $viewMode = 'testViewMode';

    hook_event_dispatcher_entity_view($build, $entity, $display, $viewMode);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityViewEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_VIEW);
    $this->assertEquals($build, $event->getBuild());
    $this->assertEquals($entity, $event->getEntity());
    $this->assertEquals($display, $event->getDisplay());
    $this->assertEquals($viewMode, $event->getViewMode());

    $newBuild = ['newBuild'];
    $event->setBuild($newBuild);
    $this->assertEquals($newBuild, $event->getBuild());
  }

}
