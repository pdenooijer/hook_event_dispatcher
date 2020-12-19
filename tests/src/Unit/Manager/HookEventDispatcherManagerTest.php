<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Manager;

use Drupal\hook_event_dispatcher\Manager\HookEventDispatcherManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class HookEventDispatcherManagerTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Manager
 *
 * @group hook_event_dispatcher
 */
class HookEventDispatcherManagerTest extends TestCase {

  /**
   * Test event dispatcher.
   */
  public function testEventDispatcher(): void {
    $event = new FakeEvent('test');
    $dispatcher = $this->createMock(EventDispatcherInterface::class);
    $dispatcher->method('dispatch')->with('test', $event)->willReturn($event);

    $manager = new HookEventDispatcherManager($dispatcher);
    $returnedEvent = $manager->register($event);
    self::assertSame($event, $returnedEvent);
  }

}
