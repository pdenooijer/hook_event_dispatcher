<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Theme;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\Theme\ThemeEvent;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\UnitTestCase;

/**
 * Class ThemeEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Theme
 *
 * @group hook_event_dispatcher
 */
class ThemeEventTest extends UnitTestCase {

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
   * ThemeEvent with addNewThemes test.
   */
  public function testThemeEventWithAddNewThemes() {
    $newThemes = [
      'some_custom__hook_theme' => [
        'variables' => [
          'custom_variable' => NULL,
        ],
        'path' => 'some/path',
      ],
    ];
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::THEME => function (ThemeEvent $event) use ($newThemes) {
        $event->addNewThemes($newThemes);
      },
    ]);

    $existing = [
      'existing_theme_hook__with_information' => [
        'render element' => [
          '#type' => 'date',
          '#title' => 'Some date',
          '#default_value' => [
            'year' => 2020,
            'month' => 2,
            'day' => 15,
          ],
        ],
      ],
    ];

    $hookNewInformation = hook_event_dispatcher_theme($existing);

    /** @var \Drupal\hook_event_dispatcher\Event\Theme\ThemeEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::THEME);
    $this->assertSame($existing, $event->getExisting());
    $this->assertSame($newThemes, $hookNewInformation);
  }

  /**
   * ThemeEvent with addNewThemes test.
   */
  public function testThemeEventWithAddNewThemesPathException() {
    $newThemes = [
      'some_custom__hook_theme' => [
        'variables' => [
          'custom_variable' => NULL,
        ],
      ],
    ];
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::THEME => function (ThemeEvent $event) use ($newThemes) {
        $event->addNewThemes($newThemes);
      },
    ]);

    $this->expectException(\RuntimeException::class);
    $this->expectExceptionMessage('Missing path in the information array. ThemeEvent needs the path to be set manually, to have a proper default theme implementation. See \hook_theme() for more information.');

    hook_event_dispatcher_theme([]);
  }

  /**
   * ThemeEvent with addNewTheme test.
   */
  public function testThemeEventWithAddNewTheme() {
    $themeHook = 'extra_theme__hook';
    $information = [
      'test' => 'extra_theme_information',
      'path' => 'some/path',
    ];
    $expectedNewTheme[$themeHook] = $information;

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::THEME => function (ThemeEvent $event) use ($themeHook, $information) {
        $event->addNewTheme($themeHook, $information);
      },
    ]);

    $existing = [
      'existing_theme_hook__with_information' => [
        'render element' => [
          '#type' => 'date',
          '#title' => 'Some date',
          '#default_value' => [
            'year' => 2020,
            'month' => 2,
            'day' => 15,
          ],
        ],
      ],
    ];

    $hookNewInformation = hook_event_dispatcher_theme($existing);

    /** @var \Drupal\hook_event_dispatcher\Event\Theme\ThemeEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::THEME);
    $this->assertSame($existing, $event->getExisting());
    $this->assertSame($expectedNewTheme, $hookNewInformation);
  }

  /**
   * ThemeEvent with addNewTheme test.
   */
  public function testThemeEventWithAddNewThemeWithPathException() {
    $themeHook = 'extra_theme__hook';
    $information = [
      'test' => 'extra_theme_information',
    ];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::THEME => function (ThemeEvent $event) use ($themeHook, $information) {
        $event->addNewTheme($themeHook, $information);
      },
    ]);

    $this->expectException(\RuntimeException::class);
    $this->expectExceptionMessage('Missing path in the information array. ThemeEvent needs the path to be set manually, to have a proper default theme implementation. See \hook_theme() for more information.');

    hook_event_dispatcher_theme([]);
  }

}
