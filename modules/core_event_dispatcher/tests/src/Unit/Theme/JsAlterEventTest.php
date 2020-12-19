<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Theme;

use Drupal;
use Drupal\Core\Asset\AttachedAssets;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\core_event_dispatcher\Event\Theme\JsAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function core_event_dispatcher_js_alter;

/**
 * Class JsAlterEventTest.
 *
 * @group hook_event_dispatcher
 */
final class JsAlterEventTest extends TestCase {

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
   * JsAlterEvent test.
   */
  public function testJsAlterEvent(): void {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::JS_ALTER => static function (JsAlterEvent $event) {
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

    core_event_dispatcher_js_alter($javascript, $attachedAssets);

    /** @var \Drupal\core_event_dispatcher\Event\Theme\JsAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::JS_ALTER);
    self::assertSame($expectedJavascript, $event->getJavascript());
    self::assertSame($attachedAssets, $event->getAttachedAssets());
  }

}
