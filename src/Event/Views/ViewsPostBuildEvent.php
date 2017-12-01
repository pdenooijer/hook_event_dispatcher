<?php

namespace Drupal\hook_event_dispatcher\Event\Views;

use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;

/**
 * Class ViewsPostBuildEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Views
 */
class ViewsPostBuildEvent extends BaseViewsEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::VIEWS_POST_BUILD;
  }

}
