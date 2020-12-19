<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Theme;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\core_event_dispatcher\Event\Theme\LibraryInfoAlterEvent;
use PHPUnit\Framework\TestCase;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use function core_event_dispatcher_library_info_alter;

/**
 * Class LibraryInfoAlterEventTest.
 *
 * @group hook_event_dispatcher
 */
class LibraryInfoAlterEventTest extends TestCase {

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
   * Test the LibraryInfoAlterEventTest.
   */
  public function testLibraryInfoAlterEvent(): void {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::LIBRARY_INFO_ALTER => static function (LibraryInfoAlterEvent $event) {
        $libraries = &$event->getLibraries();
        $libraries['test_library'] = 'test_altered';
      },
    ]);

    $libraries = $expectedLibraries = [
      'test_library' => 'test',
    ];
    $extension = 'test_module';

    core_event_dispatcher_library_info_alter($libraries, $extension);

    $expectedLibraries['test_library'] = 'test_altered';
    self::assertSame($expectedLibraries, $libraries);

    /** @var \Drupal\core_event_dispatcher\Event\Theme\LibraryInfoAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::LIBRARY_INFO_ALTER);
    self::assertSame($expectedLibraries, $event->getLibraries());
    self::assertSame($extension, $event->getExtension());
  }

}
