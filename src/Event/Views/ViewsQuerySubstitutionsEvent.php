<?php

namespace Drupal\hook_event_dispatcher\Event\Views;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\views\Plugin\views\query\QueryPluginBase;
use Drupal\views\ViewExecutable;

/**
 * Class ViewsQuerySubstitutionEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Views
 */
final class ViewsQuerySubstitutionsEvent extends BaseViewsEvent {

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::VIEWS_QUERY_SUBSTITUTIONS;
  }

}
