<?php

namespace Drupal\hook_event_dispatcher\Event\Theme;

use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;

/**
 * Class ThemeSuggestionsAlterEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Theme
 */
class ThemeSuggestionsAlterEvent extends BaseThemeSuggestionsEvent {

  /**
   * Returns the hook dispatcher type.
   *
   * @return string
   *   Dispatcher type.
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::THEME_SUGGESTIONS_ALTER;
  }

}
