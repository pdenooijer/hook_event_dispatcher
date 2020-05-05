<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Entity;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\hook_event_dispatcher\Event\Entity\EntityBuildDefaultsAlterEvent;
use Drupal\hook_event_dispatcher\Event\Entity\EntityViewAlterEvent;
use Drupal\hook_event_dispatcher\Event\Entity\EntityViewEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;
use function hook_event_dispatcher_entity_view;
use function hook_event_dispatcher_entity_view_alter;

/**
 * Class EntityViewEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Entity
 *
 * @group hook_event_dispatcher
 */
final class EntityViewEventTest extends UnitTestCase {

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
    Drupal::setContainer($builder);
  }

  /**
   * Test EntityViewEvent by reference.
   */
  public function testEntityViewEventByReference() {
    $build = $expectedBuild = ['testBuild' => ['someBuild']];
    $entity = $this->createMock(EntityInterface::class);
    $display = $this->createMock(EntityViewDisplayInterface::class);
    $viewMode = 'testViewMode';

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_VIEW => static function (EntityViewEvent $event) {
        $event->getBuild()['otherBuild'] = ['aBuild'];
      },
    ]);
    $expectedBuild['otherBuild'] = ['aBuild'];

    hook_event_dispatcher_entity_view($build, $entity, $display, $viewMode);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityViewEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_VIEW);
    $this->assertSame($build, $event->getBuild());
    $this->assertSame($expectedBuild, $event->getBuild());
    $this->assertSame($entity, $event->getEntity());
    $this->assertSame($display, $event->getDisplay());
    $this->assertSame($viewMode, $event->getViewMode());
  }

  /**
   * Test EntityViewEvent by set.
   */
  public function testEntityViewEventBySet() {
    $build = ['testBuild' => ['someBuild']];
    $otherBuild = ['otherBuild' => ['lalala']];
    $entity = $this->createMock(EntityInterface::class);
    $display = $this->createMock(EntityViewDisplayInterface::class);
    $viewMode = 'testViewMode';

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_VIEW => static function (EntityViewEvent $event) use ($otherBuild) {
        $event->setBuild($otherBuild);
      },
    ]);

    hook_event_dispatcher_entity_view($build, $entity, $display, $viewMode);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityViewEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_VIEW);
    $this->assertSame($build, $event->getBuild());
    $this->assertSame($otherBuild, $event->getBuild());
    $this->assertSame($entity, $event->getEntity());
    $this->assertSame($display, $event->getDisplay());
    $this->assertSame($viewMode, $event->getViewMode());
  }

  /**
   * Test EntityViewAlterEvent.
   */
  public function testEntityViewAlterEvent() {
    $build = $expectedBuild = ['testBuild' => ['someBuild']];
    $entity = $this->createMock(EntityInterface::class);
    $display = $this->createMock(EntityViewDisplayInterface::class);

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_VIEW_ALTER => static function (EntityViewAlterEvent $event) {
        $event->getBuild()['otherBuild'] = ['aBuild'];
      },
    ]);
    $expectedBuild['otherBuild'] = ['aBuild'];

    hook_event_dispatcher_entity_view_alter($build, $entity, $display);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityViewAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_VIEW_ALTER);
    $this->assertSame($build, $event->getBuild());
    $this->assertSame($expectedBuild, $event->getBuild());
    $this->assertSame($entity, $event->getEntity());
    $this->assertSame($display, $event->getDisplay());
  }

  /**
   * Test EntityBuildDefaultsAlter.
   */
  public function testEntityBuildDefaultsAlter() {
    $build = $expectedBuild = ['testBuild' => ['someBuild']];
    $entity = $this->createMock(EntityInterface::class);
    $viewMode = 'entity_view_mode';

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_BUILD_DEFAULTS_ALTER => static function (EntityBuildDefaultsAlterEvent $event) {
        $event->getBuild()['otherBuild'] = ['aBuild'];
      },
    ]);
    $expectedBuild['otherBuild'] = ['aBuild'];

    hook_event_dispatcher_entity_build_defaults_alter($build, $entity, $viewMode);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityBuildDefaultsAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_BUILD_DEFAULTS_ALTER);
    $this->assertSame($build, $event->getBuild());
    $this->assertSame($expectedBuild, $event->getBuild());
    $this->assertSame($entity, $event->getEntity());
    $this->assertSame($viewMode, $event->getViewMode());
  }

  /**
   * Test EntityBuildDefaultsAlter.
   */
  public function testEntityBuildDefaultsAlterWithNullViewMode() {
    $build = ['testBuild' => ['someBuild']];
    $entity = $this->createMock(EntityInterface::class);
    $viewMode = NULL;

    hook_event_dispatcher_entity_build_defaults_alter($build, $entity, $viewMode);

    /* @var \Drupal\hook_event_dispatcher\Event\Entity\EntityBuildDefaultsAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_BUILD_DEFAULTS_ALTER);
    $this->assertSame($build, $event->getBuild());
    $this->assertSame($entity, $event->getEntity());
    $this->assertSame((string) $viewMode, $event->getViewMode());
  }

}
