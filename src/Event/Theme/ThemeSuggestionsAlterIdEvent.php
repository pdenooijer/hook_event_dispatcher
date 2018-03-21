<?php

namespace Drupal\hook_event_dispatcher\Event\Theme;

/**
 * Class ThemeSuggestionsAlterIdEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Theme
 */
class ThemeSuggestionsAlterIdEvent extends BaseThemeSuggestionsEvent {

  /**
   * Returns the hook dispatcher type.
   *
   * @return string
   *   Dispatcher type.
   */
  public function getDispatcherType() {
    return 'hook_event_dispatcher.theme.suggestions_' . $this->getHook() . '_alter';
  }

}
