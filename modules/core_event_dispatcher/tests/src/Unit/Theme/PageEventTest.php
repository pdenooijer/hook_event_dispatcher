<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Page;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\core_event_dispatcher\Event\Theme\PageAttachmentsEvent;
use Drupal\core_event_dispatcher\Event\Theme\PageBottomEvent;
use Drupal\core_event_dispatcher\Event\Theme\PageTopEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function core_event_dispatcher_page_attachments;
use function core_event_dispatcher_page_bottom;
use function core_event_dispatcher_page_top;

/**
 * Class PageEventTest.
 *
 * @group hook_event_dispatcher
 */
class PageEventTest extends TestCase {

  /**
   * The manager.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy
   */
  private $manager;

  /**
   * Sets up the test.
   */
  public function setUp(): void {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    Drupal::setContainer($builder);
  }

  /**
   * Test the PageAttachmentsEvent.
   */
  public function testPageAttachments(): void {
    $currentAttachments = [];
    $currentAttachments['current']['#attached']['library'] = ['current/current'];
    $testAttachment = [];
    $testAttachment['#attached']['library'] = ['test/test'];

    $expectedAttachments = $currentAttachments;
    $expectedAttachments['new'] = $testAttachment;

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::PAGE_ATTACHMENTS => static function (PageAttachmentsEvent $event) use ($testAttachment) {
        $eventAttachments = &$event->getAttachments();
        $eventAttachments['new'] = $testAttachment;
      },
    ]);

    core_event_dispatcher_page_attachments($currentAttachments);

    /** @var \Drupal\core_event_dispatcher\Event\Theme\PageAttachmentsEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::PAGE_ATTACHMENTS);
    self::assertSame($expectedAttachments, $event->getAttachments());
    self::assertSame($expectedAttachments, $currentAttachments);
  }

  /**
   * Test the PageBottomEvent.
   */
  public function testPageBottomEvent(): void {
    $pageBottom = [];
    $renderArray = [
      '#markup' => 'Bottom!',
    ];
    $expectedBuild = ['new' => $renderArray];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::PAGE_BOTTOM => static function (PageBottomEvent $event) use ($renderArray) {
        $build = &$event->getBuild();
        $build['new'] = $renderArray;
      },
    ]);

    core_event_dispatcher_page_bottom($pageBottom);

    /** @var \Drupal\core_event_dispatcher\Event\Theme\PageBottomEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::PAGE_BOTTOM);
    self::assertSame($expectedBuild, $pageBottom);
    self::assertSame($expectedBuild, $event->getBuild());
  }

  /**
   * Test the PageTopEvent.
   */
  public function testPageTopEvent(): void {
    $pageTop = [];
    $renderArray = [
      '#markup' => 'Top!',
    ];
    $expectedBuild = ['new' => $renderArray];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::PAGE_TOP => static function (PageTopEvent $event) use ($renderArray) {
        $build = &$event->getBuild();
        $build['new'] = $renderArray;
      },
    ]);

    core_event_dispatcher_page_top($pageTop);

    /** @var \Drupal\core_event_dispatcher\Event\Theme\PageTopEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::PAGE_TOP);
    self::assertSame($expectedBuild, $pageTop);
    self::assertSame($expectedBuild, $event->getBuild());
  }

}
