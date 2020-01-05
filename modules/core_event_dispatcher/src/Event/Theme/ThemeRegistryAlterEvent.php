<?php

namespace Drupal\core_event_dispatcher\Event\Theme;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ThemeRegistryAlterEvent.
 */
class ThemeRegistryAlterEvent extends Event implements EventInterface {

  /**
   * The entire cache of theme registry information, post-processing.
   *
   * @var array
   */
  private $themeRegistry;

  /**
   * ThemeRegistryAlterEvent constructor.
   *
   * @param array &$themeRegistry
   *   The entire cache of theme registry information, post-processing.
   */
  public function __construct(array &$themeRegistry) {
    $this->themeRegistry = &$themeRegistry;
  }

  /**
   * Get theme registry.
   *
   * @return array
   *   The theme registry.
   */
  public function &getThemeRegistry(): array {
    return $this->themeRegistry;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::THEME_REGISTRY_ALTER;
  }

}
