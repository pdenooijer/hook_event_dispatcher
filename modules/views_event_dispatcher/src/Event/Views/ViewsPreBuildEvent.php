<?php

namespace Drupal\views_event_dispatcher\Event\Views;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class ViewsPreBuildEvent.
 */
class ViewsPreBuildEvent extends AbstractViewsEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::VIEWS_PRE_BUILD;
  }

}
