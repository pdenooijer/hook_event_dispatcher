<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Theme;

use Drupal\Core\Asset\AttachedAssets;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\Theme\JsAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class JsAlterEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Theme
 *
 * @group hook_event_dispatcher
 */
final class JsAlterEventTest extends UnitTestCase {

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
   * JsAlterEvent by reference test.
   */
  public function testJsAlterEventByReference() {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::JS_ALTER => function (JsAlterEvent $event) {
        $javascript = &$event->getJavascript();
        unset($javascript['unset']);
      },
    ]);

    $javascript = $expectedJavascript = [
      'unset' => ['data'],
      'other' => ['other_data'],
    ];
    unset($expectedJavascript['unset']);

    $attachedAssets = new AttachedAssets();

    hook_event_dispatcher_js_alter($javascript, $attachedAssets);

    /** @var \Drupal\hook_event_dispatcher\Event\Theme\JsAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::JS_ALTER);

    $this->assertSame($expectedJavascript, $event->getJavascript());
    $this->assertSame($attachedAssets, $event->getAttachedAssets());
  }

  /**
   * JsAlterEvent by set test.
   */
  public function testJsAlterEventBySet() {
    $newJavascript = [
      'new' => ['new-data'],
    ];
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::JS_ALTER => function (JsAlterEvent $event) use ($newJavascript) {
        $javascript = $event->getJavascript();
        $javascript += $newJavascript;
        $event->setJavascript($javascript);
      },
    ]);

    $javascript = $expectedJavascript = [
      'some' => ['data'],
      'other' => ['other_data'],
    ];
    $expectedJavascript += $newJavascript;

    $attachedAssets = new AttachedAssets();

    hook_event_dispatcher_js_alter($javascript, $attachedAssets);

    /** @var \Drupal\hook_event_dispatcher\Event\Theme\JsAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::JS_ALTER);

    $this->assertSame($expectedJavascript, $event->getJavascript());
    $this->assertSame($attachedAssets, $event->getAttachedAssets());
  }

}
