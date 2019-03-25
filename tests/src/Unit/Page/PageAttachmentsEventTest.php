<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Page;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\Page\PageAttachmentsEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class PageAttachmentsEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Page
 *
 * @group hook_event_dispatcher
 */
class PageAttachmentsEventTest extends UnitTestCase {

  /**
   * The manager.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy
   */
  private $manager;

  /**
   * Sets up the test.
   */
  public function setUp() {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    \Drupal::setContainer($builder);
  }

  /**
   * Test the PageAttachmentsEvent by reference.
   */
  public function testPageAttachmentsByReference() {
    $testAttachments = ['#attached' => ['library' => ['test/test']]];
    $expectedBuild['new'] = $testAttachments;

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::PAGE_ATTACHMENTS => function (PageAttachmentsEvent $event) use ($testAttachments) {
        $eventAttachments = &$event->getAttachments();
        $eventAttachments['new'] = $testAttachments;
      },
    ]);

    hook_event_dispatcher_page_attachments($testAttachments);

    /* @var \Drupal\hook_event_dispatcher\Event\Page\PageAttachmentsEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::PAGE_ATTACHMENTS);
    $this->assertSame($expectedBuild, $event->getAttachments());
  }

  /**
   * Test the PageAttachmentsEvent by set.
   */
  public function testPageAttachmentsBySet() {
    $testAttachments = ['#attached' => ['library' => ['test/test']]];
    $expectedBuild['new'] = $testAttachments;

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::PAGE_ATTACHMENTS => function (PageAttachmentsEvent $event) use ($testAttachments) {
        $eventAttachments = $event->getAttachments();
        $eventAttachments['new'] = $testAttachments;
        $event->setAttachments($eventAttachments);
      },
    ]);

    hook_event_dispatcher_page_attachments($testAttachments);

    /* @var \Drupal\hook_event_dispatcher\Event\Page\PageAttachmentsEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::PAGE_ATTACHMENTS);
    $this->assertSame($expectedBuild, $event->getAttachments());
  }

}
