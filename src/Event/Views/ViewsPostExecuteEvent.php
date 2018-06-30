<?php

namespace Drupal\hook_event_dispatcher\Event\Views;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class ViewsPostExecuteEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Views
 */
class ViewsPostExecuteEvent extends BaseViewsEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::VIEWS_POST_EXECUTE;
  }

}
