<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Entity;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\core_event_dispatcher\Event\Entity\EntityViewAlterEvent;
use Drupal\core_event_dispatcher\Event\Entity\EntityViewEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;
use function core_event_dispatcher_entity_view;
use function core_event_dispatcher_entity_view_alter;

/**
 * Class EntityViewEventTest.
 *
 * @group core_event_dispatcher
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

    /* @var \Drupal\core_event_dispatcher\Event\Entity\EntityViewEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_VIEW);
    $this->assertSame($build, $event->getBuild());
    $this->assertSame($expectedBuild, $event->getBuild());
    $this->assertSame($entity, $event->getEntity());
    $this->assertSame($display, $event->getDisplay());
    $this->assertSame($viewMode, $event->getViewMode());
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

    /* @var \Drupal\core_event_dispatcher\Event\Entity\EntityViewAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_VIEW_ALTER);
    $this->assertSame($build, $event->getBuild());
    $this->assertSame($expectedBuild, $event->getBuild());
    $this->assertSame($entity, $event->getEntity());
    $this->assertSame($display, $event->getDisplay());
  }

}
