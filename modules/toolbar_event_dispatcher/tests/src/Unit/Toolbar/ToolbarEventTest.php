<?php

namespace Drupal\Tests\toolbar_event_dispatcher\Unit\Toolbar;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\toolbar_event_dispatcher\Event\Toolbar\ToolbarEvent;
use PHPUnit\Framework\TestCase;
use function toolbar_event_dispatcher_toolbar;

/**
 * Class ToolbarEventTest.
 *
 * @group toolbar_event_dispatcher
 */
class ToolbarEventTest extends TestCase {

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
   * Test the ToolbarAlterEvent.
   */
  public function testToolbarEvent(): void {
    toolbar_event_dispatcher_toolbar();

    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::TOOLBAR);

    self::assertInstanceOf(ToolbarEvent::class, $event);
  }

}
