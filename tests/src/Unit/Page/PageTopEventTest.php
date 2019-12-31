<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Page;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\Page\PageTopEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class PageTopEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Page
 *
 * @group hook_event_dispatcher
 */
class PageTopEventTest extends UnitTestCase {

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
   * Test the PageTopEvent.
   */
  public function testPageTopEvent() {
    $pageTop = [];
    $renderArray = [
      '#markup' => 'Top!',
    ];
    $expectedBuild['new'] = $renderArray;

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::PAGE_TOP => function (PageTopEvent $event) use ($renderArray) {
        $build = &$event->getBuild();
        $build['new'] = $renderArray;
      },
    ]);

    hook_event_dispatcher_page_top($pageTop);

    /* @var \Drupal\hook_event_dispatcher\Event\Page\PageTopEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::PAGE_TOP);
    $this->assertSame($expectedBuild, $event->getBuild());
  }

}
