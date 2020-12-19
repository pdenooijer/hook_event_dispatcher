<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Theme;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\core_event_dispatcher\Event\Theme\ThemeSuggestionsAlterEvent;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use PHPUnit\Framework\TestCase;
use function core_event_dispatcher_theme_suggestions_alter;

/**
 * Class ThemeSuggestionsAlterEventTest.
 *
 * @group hook_event_dispatcher
 */
class ThemeSuggestionsAlterEventTest extends TestCase {

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
   * Tests the themeSuggestionsAlterEvent.
   */
  public function testThemeSuggestionsAlterEvent(): void {
    $this->manager->setMaxEventCount(2);
    $suggestions = $expectedSuggestions = [
      'container_theme_function_1',
      'container_theme_function_2',
      'container_theme_function_3',
    ];
    $expectedSuggestions[] = 'extra_suggestion';
    $variables = ['content' => 'test'];
    $hook = 'container';

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::THEME_SUGGESTIONS_ALTER => static function (ThemeSuggestionsAlterEvent $event) {
        $suggestions = &$event->getSuggestions();
        $suggestions[] = 'extra_suggestion';
      },
    ]);

    core_event_dispatcher_theme_suggestions_alter($suggestions, $variables, $hook);

    /** @var \Drupal\core_event_dispatcher\Event\Theme\ThemeSuggestionsAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::THEME_SUGGESTIONS_ALTER);
    self::assertSame($expectedSuggestions, $suggestions);
    self::assertEquals($suggestions, $event->getSuggestions());
    self::assertEquals($variables, $event->getVariables());
  }

  /**
   * Tests the ThemeSuggestionsAlterIdEvent.
   */
  public function testThemeSuggestionsAlterIdEvent(): void {
    $this->manager->setMaxEventCount(2);
    $suggestions = [
      'container_theme_function_1',
      'container_theme_function_2',
      'container_theme_function_3',
    ];
    $variables = ['content' => 'test'];
    $hook = 'container';

    core_event_dispatcher_theme_suggestions_alter($suggestions, $variables, $hook);

    /** @var \Drupal\core_event_dispatcher\Event\Theme\ThemeSuggestionsAlterIdEvent $event */
    $event = $this->manager->getRegisteredEvent('hook_event_dispatcher.theme.suggestions_' . $hook . '_alter');
    self::assertEquals($suggestions, $event->getSuggestions());
    self::assertEquals($variables, $event->getVariables());
  }

}
