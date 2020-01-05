<?php

namespace Drupal\core_event_dispatcher\Event\Theme;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class PageBottomEvent.
 */
class PageBottomEvent extends Event implements EventInterface {

  /**
   * The build array.
   *
   * @var array
   */
  private $build;

  /**
   * PageBottomEvent constructor.
   *
   * @param array $build
   *   The build array.
   */
  public function __construct(array &$build) {
    $this->build = &$build;
  }

  /**
   * Get the build array.
   *
   * @return array
   *   The build array.
   */
  public function &getBuild(): array {
    return $this->build;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::PAGE_BOTTOM;
  }

}
