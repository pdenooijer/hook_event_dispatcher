<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Entity;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\core_event_dispatcher\Event\Entity\EntityBuildDefaultsAlterEvent;
use Drupal\core_event_dispatcher\Event\Entity\EntityViewAlterEvent;
use Drupal\core_event_dispatcher\Event\Entity\EntityViewEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function core_event_dispatcher_entity_view;
use function core_event_dispatcher_entity_view_alter;

/**
 * Class EntityViewEventTest.
 *
 * @group core_event_dispatcher
 */
final class EntityViewEventTest extends TestCase {

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
   * Test EntityViewEvent by reference.
   */
  public function testEntityViewEventByReference(): void {
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

    core_event_dispatcher_entity_view($build, $entity, $display, $viewMode);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityViewEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_VIEW);
    self::assertSame($build, $event->getBuild());
    self::assertSame($expectedBuild, $event->getBuild());
    self::assertSame($entity, $event->getEntity());
    self::assertSame($display, $event->getDisplay());
    self::assertSame($viewMode, $event->getViewMode());
  }

  /**
   * Test EntityViewAlterEvent.
   */
  public function testEntityViewAlterEvent(): void {
    $build = $expectedBuild = ['testBuild' => ['someBuild']];
    $entity = $this->createMock(EntityInterface::class);
    $display = $this->createMock(EntityViewDisplayInterface::class);

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_VIEW_ALTER => static function (EntityViewAlterEvent $event) {
        $event->getBuild()['otherBuild'] = ['aBuild'];
      },
    ]);
    $expectedBuild['otherBuild'] = ['aBuild'];

    core_event_dispatcher_entity_view_alter($build, $entity, $display);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityViewAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_VIEW_ALTER);
    self::assertSame($build, $event->getBuild());
    self::assertSame($expectedBuild, $event->getBuild());
    self::assertSame($entity, $event->getEntity());
    self::assertSame($display, $event->getDisplay());
  }

  /**
   * Test EntityBuildDefaultsAlter.
   */
  public function testEntityBuildDefaultsAlter(): void {
    $build = $expectedBuild = ['testBuild' => ['someBuild']];
    $entity = $this->createMock(EntityInterface::class);
    $viewMode = 'entity_view_mode';

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_BUILD_DEFAULTS_ALTER => static function (EntityBuildDefaultsAlterEvent $event) {
        $event->getBuild()['otherBuild'] = ['aBuild'];
      },
    ]);
    $expectedBuild['otherBuild'] = ['aBuild'];

    core_event_dispatcher_entity_build_defaults_alter($build, $entity, $viewMode);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityBuildDefaultsAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_BUILD_DEFAULTS_ALTER);
    self::assertSame($build, $event->getBuild());
    self::assertSame($expectedBuild, $event->getBuild());
    self::assertSame($entity, $event->getEntity());
    self::assertSame($viewMode, $event->getViewMode());
  }

  /**
   * Test EntityBuildDefaultsAlter.
   */
  public function testEntityBuildDefaultsAlterWithNullViewMode(): void {
    $build = ['testBuild' => ['someBuild']];
    $entity = $this->createMock(EntityInterface::class);
    $viewMode = NULL;

    core_event_dispatcher_entity_build_defaults_alter($build, $entity, $viewMode);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityBuildDefaultsAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_BUILD_DEFAULTS_ALTER);
    self::assertSame($build, $event->getBuild());
    self::assertSame($entity, $event->getEntity());
    self::assertSame((string) $viewMode, $event->getViewMode());
  }

}
