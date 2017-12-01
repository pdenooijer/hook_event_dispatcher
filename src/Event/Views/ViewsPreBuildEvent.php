<?php

namespace Drupal\hook_event_dispatcher\Event\Views;

use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;

/**
 * Class ViewsPreBuildEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Views
 */
class ViewsPreBuildEvent extends BaseViewsEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::VIEWS_PRE_BUILD;
  }

}
