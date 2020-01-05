<?php

namespace Drupal\core_event_dispatcher\Event\Theme;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use RuntimeException;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ThemeEvent.
 */
final class ThemeEvent extends Event implements EventInterface {

  /**
   * Existing implementations.
   *
   * @var array
   */
  private $existing;
  /**
   * Added themes.
   *
   * @var array
   */
  private $newThemes = [];

  /**
   * ThemeEvent constructor.
   *
   * @param array $existing
   *   An array of existing implementations that may be used for override
   *   purposes. This is primarily useful for themes that may wish to examine
   *   existing implementations to extract data (such as arguments) so that
   *   it may properly register its own, higher priority implementations.
   *
   * @see \hook_theme()
   */
  public function __construct(array $existing) {
    $this->existing = $existing;
  }

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::THEME;
  }

  /**
   * Get the existing implementations.
   *
   * @return array
   *   The existing implementations.
   */
  public function getExisting(): array {
    return $this->existing;
  }

  /**
   * Get the new themes.
   *
   * @return array
   *   The new theme information.
   */
  public function getNewThemes(): array {
    return $this->newThemes;
  }

  /**
   * Add new theme.
   *
   * @param string $theme
   *   Theme hook.
   * @param array $information
   *   Information array.
   *
   * @see \hook_theme()
   * Have a look at the return statement.
   *
   * @throws \RuntimeException
   */
  public function addNewTheme($theme, array $information) {
    if (empty($information['path'])) {
      throw new RuntimeException(
        'Missing path in the information array. ThemeEvent needs the path to be set manually, to have a proper default theme implementation. See \hook_theme() for more information.'
      );
    }
    $this->newThemes[$theme] = $information;
  }

  /**
   * Add new themes.
   *
   * @param array $themes
   *   The new theme information.
   *
   * @see \hook_theme()
   * Have a look at the return statement.
   *
   * @throws \RuntimeException
   */
  public function addNewThemes(array $themes) {
    foreach ($themes as $theme => $information) {
      $this->addNewTheme($theme, $information);
    }
  }

}
