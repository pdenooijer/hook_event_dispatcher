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
   * Test the PageAttachmentsEvent by set.
   */
  public function testPageAttachmentsBySet() {
    $currentAttachments['current']['#attached']['library'] = ['current/current'];
    $testAttachment['#attached']['library'] = ['test/test'];

    $expectedAttachments = $currentAttachments;
    $expectedAttachments['new'] = $testAttachment;

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::PAGE_ATTACHMENTS => static function (PageAttachmentsEvent $event) use ($testAttachment) {
        $eventAttachments = $event->getAttachments();
        $eventAttachments['new'] = $testAttachment;
        $event->setAttachments($eventAttachments);
      },
    ]);

    hook_event_dispatcher_page_attachments($currentAttachments);

    /* @var \Drupal\hook_event_dispatcher\Event\Page\PageAttachmentsEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::PAGE_ATTACHMENTS);
    $this->assertSame($expectedAttachments, $event->getAttachments());
    $this->assertSame($expectedAttachments, $currentAttachments);
  }

}
