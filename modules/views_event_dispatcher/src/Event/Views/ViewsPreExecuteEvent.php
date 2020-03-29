<?php

namespace Drupal\views_event_dispatcher\Event\Views;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class ViewsPreExecuteEvent.
 */
class ViewsPreExecuteEvent extends AbstractViewsEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::VIEWS_PRE_EXECUTE;
  }

}
