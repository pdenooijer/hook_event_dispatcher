<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Theme;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\core_event_dispatcher\Event\Theme\ThemeEvent;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use function core_event_dispatcher_theme;

/**
 * Class ThemeEventTest.
 *
 * @group hook_event_dispatcher
 */
class ThemeEventTest extends TestCase {

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
   * ThemeEvent with addNewThemes test.
   */
  public function testThemeEventWithAddNewThemes(): void {
    $newThemes = [
      'some_custom__hook_theme' => [
        'variables' => [
          'custom_variable' => NULL,
        ],
        'path' => 'some/path',
      ],
    ];
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::THEME => static function (ThemeEvent $event) use ($newThemes) {
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

    $hookNewInformation = core_event_dispatcher_theme($existing);

    /** @var \Drupal\core_event_dispatcher\Event\Theme\ThemeEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::THEME);
    self::assertSame($existing, $event->getExisting());
    self::assertSame($newThemes, $hookNewInformation);
    self::assertSame($newThemes, $event->getNewThemes());
  }

  /**
   * ThemeEvent with addNewThemes test.
   */
  public function testThemeEventWithAddNewThemesPathException(): void {
    $newThemes = [
      'some_custom__hook_theme' => [
        'variables' => [
          'custom_variable' => NULL,
        ],
      ],
    ];
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::THEME => static function (ThemeEvent $event) use ($newThemes) {
        $event->addNewThemes($newThemes);
      },
    ]);

    $this->expectException(RuntimeException::class);
    $this->expectExceptionMessage('Missing path in the information array. ThemeEvent needs the path to be set manually, to have a proper default theme implementation. See \hook_theme() for more information.');

    core_event_dispatcher_theme([]);
  }

  /**
   * ThemeEvent with addNewTheme test.
   */
  public function testThemeEventWithAddNewTheme(): void {
    $themeHook = 'extra_theme__hook';
    $information = [
      'test' => 'extra_theme_information',
      'path' => 'some/path',
    ];
    $expectedNewTheme = [$themeHook => $information];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::THEME => static function (ThemeEvent $event) use ($themeHook, $information) {
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

    $hookNewInformation = core_event_dispatcher_theme($existing);

    /** @var \Drupal\core_event_dispatcher\Event\Theme\ThemeEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::THEME);
    self::assertSame($existing, $event->getExisting());
    self::assertSame($expectedNewTheme, $hookNewInformation);
    self::assertSame($expectedNewTheme, $event->getNewThemes());
  }

  /**
   * ThemeEvent with addNewTheme test.
   */
  public function testThemeEventWithAddNewThemeWithPathException(): void {
    $themeHook = 'extra_theme__hook';
    $information = [
      'test' => 'extra_theme_information',
    ];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::THEME => static function (ThemeEvent $event) use ($themeHook, $information) {
        $event->addNewTheme($themeHook, $information);
      },
    ]);

    $this->expectException(RuntimeException::class);
    $this->expectExceptionMessage('Missing path in the information array. ThemeEvent needs the path to be set manually, to have a proper default theme implementation. See \hook_theme() for more information.');

    core_event_dispatcher_theme([]);
  }

}
