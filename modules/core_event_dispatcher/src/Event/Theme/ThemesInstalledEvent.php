<?php

namespace Drupal\core_event_dispatcher\Event\Theme;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ThemesInstalledEvent.
 */
class ThemesInstalledEvent extends Event implements EventInterface {

  /**
   * Theme list.
   *
   * @var array
   */
  private $themeList;

  /**
   * ThemesInstalledEvent constructor.
   *
   * @param array $themeList
   *   Array containing the names of the themes being installed.
   */
  public function __construct(array $themeList) {
    $this->themeList = $themeList;
  }

  /**
   * Get theme list.
   *
   * @return array
   *   Theme list.
   */
  public function getThemeList(): array {
    return $this->themeList;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::THEMES_INSTALLED;
  }

}
