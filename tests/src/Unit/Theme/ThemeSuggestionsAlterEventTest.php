<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Theme;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\Theme\ThemeSuggestionsAlterEvent;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\UnitTestCase;

/**
 * Class ThemeSuggestionsAlterEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Theme
 *
 * @group hook_event_dispatcher
 */
class ThemeSuggestionsAlterEventTest extends UnitTestCase {

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
   * Tests the themeSuggestionsAlterEvent.
   */
  public function testThemeSuggestionsAlterEvent() {
    $this->manager->setMaxEventCount(2);
    $suggestions = [
      'container_theme_function_1',
      'container_theme_function_2',
      'container_theme_function_3'
    ];
    $variables = ['content' => 'test'];
    $hook = 'container';

    hook_event_dispatcher_theme_suggestions_alter($suggestions, $variables, $hook);

    /** @var \Drupal\hook_event_dispatcher\Event\Theme\ThemeSuggestionsAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::THEME_SUGGESTIONS_ALTER);
    $this->assertEquals($suggestions, $event->getSuggestions());
    $this->assertEquals($variables, $event->getVariables());
  }

  /**
   * Tests the themeSuggestionsAlterEvent with setSuggestion.
   */
  public function testThemeSuggestionsAlterEventWithSetSuggestions() {
    $this->manager->setMaxEventCount(2);
    $suggestions = [
      'container_theme_function_1',
      'container_theme_function_2',
      'container_theme_function_3'
    ];
    $variables = ['content' => 'test'];
    $hook = 'container';

    $newSuggestions = [
      'container_theme_function_1',
      'container_theme_function_2',
    ];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::THEME_SUGGESTIONS_ALTER => function (ThemeSuggestionsAlterEvent $event) use ($newSuggestions) {
        $event->setSuggestions($newSuggestions);
      },
    ]);

    hook_event_dispatcher_theme_suggestions_alter($suggestions, $variables, $hook);

    /** @var \Drupal\hook_event_dispatcher\Event\Theme\ThemeSuggestionsAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::THEME_SUGGESTIONS_ALTER);
    $this->assertEquals($newSuggestions, $event->getSuggestions());
    $this->assertEquals($variables, $event->getVariables());
  }

  /**
   * Tests the ThemeSuggestionsAlterIdEvent.
   */
  public function testThemeSuggestionsAlterIdEvent() {
    $this->manager->setMaxEventCount(2);
    $suggestions = [
      'container_theme_function_1',
      'container_theme_function_2',
      'container_theme_function_3'
    ];
    $variables = ['content' => 'test'];
    $hook = 'container';

    hook_event_dispatcher_theme_suggestions_alter($suggestions, $variables, $hook);

    /** @var \Drupal\hook_event_dispatcher\Event\Theme\ThemeSuggestionsAlterIdEvent $event */
    $event = $this->manager->getRegisteredEvent('hook_event_dispatcher.theme.suggestions_' . $hook . '_alter');
    $this->assertEquals($suggestions, $event->getSuggestions());
    $this->assertEquals($variables, $event->getVariables());
  }

}
