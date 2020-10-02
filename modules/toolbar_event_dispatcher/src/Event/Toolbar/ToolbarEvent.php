<?php

namespace Drupal\toolbar_event_dispatcher\Event\Toolbar;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ToolbarEvent.
 */
final class ToolbarEvent extends Event implements EventInterface {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::TOOLBAR;
  }

}
