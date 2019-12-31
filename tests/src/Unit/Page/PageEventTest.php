<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Page;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\Page\PageAttachmentsEvent;
use Drupal\hook_event_dispatcher\Event\Page\PageBottomEvent;
use Drupal\hook_event_dispatcher\Event\Page\PageTopEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;
use function hook_event_dispatcher_page_attachments;
use function hook_event_dispatcher_page_bottom;
use function hook_event_dispatcher_page_top;

/**
 * Class PageEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Page
 *
 * @group hook_event_dispatcher
 */
class PageEventTest extends UnitTestCase {

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
    $currentAttachments['current']['#attached']['library'] = ['current/current'];
    $testAttachment['#attached']['library'] = ['test/test'];

    $expectedAttachments = $currentAttachments;
    $expectedAttachments['new'] = $testAttachment;

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::PAGE_ATTACHMENTS => static function (PageAttachmentsEvent $event) use ($testAttachment) {
        $eventAttachments = &$event->getAttachments();
        $eventAttachments['new'] = $testAttachment;
      },
    ]);

    hook_event_dispatcher_page_attachments($currentAttachments);

    /* @var \Drupal\hook_event_dispatcher\Event\Page\PageAttachmentsEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::PAGE_ATTACHMENTS);
    $this->assertSame($expectedAttachments, $event->getAttachments());
    $this->assertSame($expectedAttachments, $currentAttachments);
  }

  /**
   * Test the PageBottomEvent.
   */
  public function testPageBottomEvent(): void {
    $pageBottom = [];
    $renderArray = [
      '#markup' => 'Bottom!',
    ];
    $expectedBuild['new'] = $renderArray;

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::PAGE_BOTTOM => static function (PageBottomEvent $event) use ($renderArray) {
        $build = &$event->getBuild();
        $build['new'] = $renderArray;
      },
    ]);

    hook_event_dispatcher_page_bottom($pageBottom);

    /* @var \Drupal\hook_event_dispatcher\Event\Page\PageBottomEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::PAGE_BOTTOM);
    $this->assertSame($expectedBuild, $pageBottom);
    $this->assertSame($expectedBuild, $event->getBuild());
  }

  /**
   * Test the PageTopEvent.
   */
  public function testPageTopEvent(): void {
    $pageTop = [];
    $renderArray = [
      '#markup' => 'Top!',
    ];
    $expectedBuild['new'] = $renderArray;

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::PAGE_TOP => static function (PageTopEvent $event) use ($renderArray) {
        $build = &$event->getBuild();
        $build['new'] = $renderArray;
      },
    ]);

    hook_event_dispatcher_page_top($pageTop);

    /* @var \Drupal\hook_event_dispatcher\Event\Page\PageTopEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::PAGE_TOP);
    $this->assertSame($expectedBuild, $pageTop);
    $this->assertSame($expectedBuild, $event->getBuild());
  }

}
