<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Manager;

use Drupal\hook_event_dispatcher\Manager\HookEventDispatcherManager;
use Drupal\Tests\UnitTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class HookEventDispatcherManagerTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Manager
 *
 * @group hook_event_dispatcher
 */
class HookEventDispatcherManagerTest extends UnitTestCase {

  /**
   * Test event dispatcher.
   */
  public function testEventDispatcher() {
    $event = new FakeEvent('test');
    $dispatcher = $this->createMock(EventDispatcherInterface::class);
    $dispatcher->method('dispatch')->with('test', $event)->willReturn($event);

    $manager = new HookEventDispatcherManager($dispatcher);
    $returnedEvent = $manager->register($event);
    $this->assertEquals($event, $returnedEvent);
  }

}
