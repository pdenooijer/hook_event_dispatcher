<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Theme;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;
use function hook_event_dispatcher_themes_installed;

/**
 * Class ThemesInstalledEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Theme
 *
 * @group hook_event_dispatcher
 */
class ThemesInstalledEventTest extends UnitTestCase {

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
   * Themes installed event test.
   */
  public function testThemesInstalledEvent(): void {
    $themes = ['classy', 'bartik'];

    hook_event_dispatcher_themes_installed($themes);

    /* @var \Drupal\hook_event_dispatcher\Event\Theme\ThemesInstalledEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::THEMES_INSTALLED);
    $this->assertSame($themes, $event->getThemeList());
  }

}
