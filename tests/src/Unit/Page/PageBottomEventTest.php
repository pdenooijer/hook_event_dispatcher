<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Page;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\Page\PageBottomEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class PageBottomEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Page
 *
 * @group hook_event_dispatcher
 */
class PageBottomEventTest extends UnitTestCase {

  /**
   * The manager.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy
   */
  private $manager;

  /**
   * Sets up the test.
   */
  public function setUp() {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    \Drupal::setContainer($builder);
  }

  /**
   * Test the PageBottomEvent by reference.
   */
  public function testPageBottomEventByReference() {
    $pageBottom = [];
    $renderArray = [
      '#markup' => 'Bottom!',
    ];
    $expectedBuild['new'] = $renderArray;

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::PAGE_BOTTOM => function (PageBottomEvent $event) use ($renderArray) {
        $build = &$event->getBuild();
        $build['new'] = $renderArray;
      },
    ]);

    hook_event_dispatcher_page_bottom($pageBottom);

    /* @var \Drupal\hook_event_dispatcher\Event\Page\PageBottomEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::PAGE_BOTTOM);
    $this->assertSame($expectedBuild, $event->getBuild());
  }

  /**
   * Test the PageBottomEvent by set.
   */
  public function testPageBottomEventBySet() {
    $pageBottom = [];
    $renderArray = [
      '#markup' => 'Bottom!',
    ];
    $expectedBuild['new'] = $renderArray;

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::PAGE_BOTTOM => function (PageBottomEvent $event) use ($renderArray) {
        $build = $event->getBuild();
        $build['new'] = $renderArray;
        $event->setBuild($build);
      },
    ]);

    hook_event_dispatcher_page_bottom($pageBottom);

    /* @var \Drupal\hook_event_dispatcher\Event\Page\PageBottomEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::PAGE_BOTTOM);
    $this->assertSame($expectedBuild, $event->getBuild());
  }

}
