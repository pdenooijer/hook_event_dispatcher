<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Theme;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\Theme\ThemeRegistryAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class ThemeRegistryAlterEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Theme
 *
 * @group hook_event_dispatcher
 */
class ThemeRegistryAlterEventTest extends UnitTestCase {

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
    Drupal::setContainer($builder);
  }

  /**
   * ThemeRegistryAlterEvent with theme implementation alter test.
   */
  public function testThemeRegistryAlterEventWithThemeAlter() {
    $themeRegistry = $expected = [
      'existing_theme_hook__with_information' => [
        'variables' => [
          'variable1' => NULL,
          'variable2' => FALSE,
          'variable3' => [],
        ],
        'type' => 'base_theme_engine',
        'template' => 'existing-theme-hook--with-information',
      ],
    ];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::THEME_REGISTRY_ALTER => function (
        ThemeRegistryAlterEvent $event
      ) {
        $themeRegistry = &$event->getThemeRegistry();
        $themeRegistry['existing_theme_hook__with_information']['variables']['variable2'] = TRUE;
      },
    ]);

    hook_event_dispatcher_theme_registry_alter($themeRegistry);

    $expected['existing_theme_hook__with_information']['variables']['variable2'] = TRUE;
    $this->assertSame($expected, $themeRegistry);

    /** @var \Drupal\hook_event_dispatcher\Event\Theme\ThemeRegistryAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(
      HookEventDispatcherInterface::THEME_REGISTRY_ALTER
    );
    $this->assertSame($expected, $event->getThemeRegistry());
  }

}
