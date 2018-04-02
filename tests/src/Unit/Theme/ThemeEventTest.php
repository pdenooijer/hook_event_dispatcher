<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Theme;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\Theme\ThemeEvent;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;
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
        ]
      ]
    ];
    $this->manager->setEventCallbacks([
      HookEventDispatcherEvents::THEME => function (ThemeEvent $event) use ($newThemes) {
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
        ]
      ]
    ];

    $hookNewInformation = hook_event_dispatcher_theme($existing);

    /** @var \Drupal\hook_event_dispatcher\Event\Theme\ThemeEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherEvents::THEME);
    $this->assertSame($existing, $event->getExisting());
    $this->assertSame($newThemes, $hookNewInformation);
  }

  /**
   * ThemeEvent with addNewTheme test.
   */
  public function testThemeEventWithAddNewTheme() {
    $themeHook = 'extra_theme__hook';
    $information = ['array_with_extra_theme_information'];
    $expectedNewTheme[$themeHook] = $information;

    $this->manager->setEventCallbacks([
      HookEventDispatcherEvents::THEME => function (ThemeEvent $event) use ($themeHook, $information) {
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
        ]
      ]
    ];

    $hookNewInformation = hook_event_dispatcher_theme($existing);

    /** @var \Drupal\hook_event_dispatcher\Event\Theme\ThemeEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherEvents::THEME);
    $this->assertSame($existing, $event->getExisting());
    $this->assertSame($expectedNewTheme, $hookNewInformation);
  }

}
