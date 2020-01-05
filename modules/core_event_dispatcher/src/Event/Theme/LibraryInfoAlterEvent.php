<?php

namespace Drupal\core_event_dispatcher\Event\Theme;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class LibraryInfoAlterEvent.
 */
class LibraryInfoAlterEvent extends Event implements EventInterface {

  /**
   * Libraries.
   *
   * @var array
   */
  private $libraries;

  /**
   * Extension machine name.
   *
   * @var string
   */
  private $extension;

  /**
   * LibraryInfoAlterEvent constructor.
   *
   * @param array $libraries
   *   An associative array of libraries registered by $extension.
   *   Keyed by internal library.
   * @param string $extension
   *   Can either be 'core' or the machine name of the extension
   *   that registered the libraries.
   */
  public function __construct(array &$libraries, string $extension) {
    $this->libraries = &$libraries;
    $this->extension = $extension;
  }

  /**
   * Get libraries info.
   *
   * @return array
   *   Libraries info.
   */
  public function &getLibraries(): array {
    return $this->libraries;
  }

  /**
   * Get the extension.
   *
   * @return string
   *   The extension.
   */
  public function getExtension(): string {
    return $this->extension;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::LIBRARY_INFO_ALTER;
  }

}
