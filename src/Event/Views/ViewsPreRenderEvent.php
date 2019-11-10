<?php

namespace Drupal\hook_event_dispatcher\Event\Views;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class ViewsPreRenderEvent.
 */
class ViewsPreRenderEvent extends BaseViewsEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::VIEWS_PRE_RENDER;
  }

}
