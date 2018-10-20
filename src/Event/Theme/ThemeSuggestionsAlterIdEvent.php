<?php

namespace Drupal\hook_event_dispatcher\Event\Theme;

/**
 * Class ThemeSuggestionsAlterIdEvent.
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
