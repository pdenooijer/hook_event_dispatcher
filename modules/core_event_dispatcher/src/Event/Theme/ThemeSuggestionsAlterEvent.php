<?php

namespace Drupal\core_event_dispatcher\Event\Theme;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class ThemeSuggestionsAlterEvent.
 */
class ThemeSuggestionsAlterEvent extends AbstractThemeSuggestionsEvent {

  /**
   * Returns the hook dispatcher type.
   *
   * @return string
   *   Dispatcher type.
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::THEME_SUGGESTIONS_ALTER;
  }

}
