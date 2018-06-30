<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Toolbar;

use Drupal\hook_event_dispatcher\Event\Toolbar\ToolbarAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;
use Drupal\Core\DependencyInjection\ContainerBuilder;

/**
 * Class ToolbarAlterEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Toolbar
 *
 * @group hook_event_dispatcher
 */
class ToolbarAlterEventTest extends UnitTestCase {

  /**
   * The manager.
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
   * Test the ToolbarAlterEvent by reference.
   */
  public function testToolbarAlterEventByReference() {
    $newItem = ['test' => 'item'];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::TOOLBAR_ALTER => function (ToolbarAlterEvent $event) use ($newItem) {
        $items = &$event->getItems();
        $items += $newItem;
      },
    ]);

    $items = [
      'user' => [],
      'manage' => [],
    ];

    $expectedItems = $items + $newItem;

    hook_event_dispatcher_toolbar_alter($items);

    $this->assertSame($expectedItems, $items);
  }

  /**
   * Test the ToolbarAlterEvent by reference.
   */
  public function testToolbarAlterEventBySet() {
    $newItem = ['test' => 'item'];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::TOOLBAR_ALTER => function (ToolbarAlterEvent $event) use ($newItem) {
        $items = $event->getItems();
        $items += $newItem;
        $event->setItems($items);
      },
    ]);

    $items = [
      'user' => [],
      'manage' => [],
    ];

    $expectedItems = $items + $newItem;

    hook_event_dispatcher_toolbar_alter($items);

    $this->assertSame($expectedItems, $items);
  }

}
