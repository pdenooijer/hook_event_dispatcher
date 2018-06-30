<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Cron;

use Drupal\hook_event_dispatcher\Event\Cron\CronEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class CronEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Cron
 *
 * @group hook_event_dispatcher
 */
final class CronEventTest extends UnitTestCase {

  /**
   * HookEventDispatcherManagerSpy.
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
   * Test the cron event.
   */
  public function testCronEvent() {
    hook_event_dispatcher_cron();

    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::CRON);

    $this->assertInstanceOf(CronEvent::class, $event);
  }

}
