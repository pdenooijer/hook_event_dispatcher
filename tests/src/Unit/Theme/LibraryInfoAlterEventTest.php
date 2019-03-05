<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Theme;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\Theme\LibraryInfoAlterEvent;
use Drupal\Tests\UnitTestCase;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class LibraryInfoAlterEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Library
 *
 * @group hook_event_dispatcher
 */
class LibraryInfoAlterEventTest extends UnitTestCase {

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
   * Test the LibraryInfoAlterEventTest.
   */
  public function testLibraryInfoAlterEvent() {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::LIBRARY_INFO_ALTER => function (LibraryInfoAlterEvent $event) {
        $libraries = &$event->getLibraries();
        $libraries['test_library'] = 'test_altered';
      },
    ]);

    $libraries = $expectedLibraries = [
      'test_library' => 'test',
    ];
    $extension = 'test_module';

    hook_event_dispatcher_library_info_alter($libraries, $extension);

    $expectedLibraries['test_library'] = 'test_altered';
    $this->assertSame($libraries, $expectedLibraries);

    /** @var \Drupal\hook_event_dispatcher\Event\Theme\LibraryInfoAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::LIBRARY_INFO_ALTER);

    $this->assertSame($libraries, $event->getLibraries());
    $this->assertSame($extension, $event->getExtension());
  }

}
