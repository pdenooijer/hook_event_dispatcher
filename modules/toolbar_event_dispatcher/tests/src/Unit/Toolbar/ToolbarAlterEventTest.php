<?php

namespace Drupal\Tests\toolbar_event_dispatcher\Unit\Toolbar;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\toolbar_event_dispatcher\Event\Toolbar\ToolbarAlterEvent;
use PHPUnit\Framework\TestCase;
use function toolbar_event_dispatcher_toolbar_alter;

/**
 * Class ToolbarAlterEventTest.
 *
 * @group toolbar_event_dispatcher
 */
class ToolbarAlterEventTest extends TestCase {

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
  public function testToolbarAlterEvent(): void {
    $newItem = ['test' => 'item'];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::TOOLBAR_ALTER => static function (ToolbarAlterEvent $event) use ($newItem) {
        $items = &$event->getItems();
        $items += $newItem;
      },
    ]);

    $items = [
      'user' => [],
      'manage' => [],
    ];

    $expectedItems = $items + $newItem;

    toolbar_event_dispatcher_toolbar_alter($items);

    /** @var \Drupal\toolbar_event_dispatcher\Event\Toolbar\ToolbarAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::TOOLBAR_ALTER);
    self::assertSame($expectedItems, $items);
    self::assertSame($expectedItems, $event->getItems());
  }

}
