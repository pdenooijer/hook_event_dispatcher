<?php

namespace Drupal\core_event_dispatcher\Event\Theme;

/**
 * Class ThemeSuggestionsAlterIdEvent.
 */
class ThemeSuggestionsAlterIdEvent extends AbstractThemeSuggestionsEvent {

  /**
   * Returns the hook dispatcher type.
   *
   * @return string
   *   Dispatcher type.
   */
  public function getDispatcherType(): string {
    return 'hook_event_dispatcher.theme.suggestions_' . $this->getHook() . '_alter';
  }

}
