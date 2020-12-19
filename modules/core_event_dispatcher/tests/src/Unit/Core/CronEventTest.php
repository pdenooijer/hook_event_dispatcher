<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Core;

use Drupal;
use Drupal\core_event_dispatcher\Event\Core\CronEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use function core_event_dispatcher_cron;

/**
 * Class CronEventTest.
 *
 * @group hook_event_dispatcher
 */
final class CronEventTest extends TestCase {

  /**
   * HookEventDispatcherManagerSpy.
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
   * Test the cron event.
   */
  public function testCronEvent(): void {
    core_event_dispatcher_cron();

    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::CRON);

    self::assertInstanceOf(CronEvent::class, $event);
  }

}
