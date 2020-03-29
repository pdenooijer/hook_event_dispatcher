<?php

namespace Drupal\views_event_dispatcher\Event\Views;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;
use function array_merge_recursive;

/**
 * Class ViewsDataEvent.
 */
final class ViewsDataEvent extends Event implements EventInterface {

  /**
   * New views data.
   *
   * @var array
   */
  private $data = [];

  /**
   * Add data to the views data.
   *
   * @param array $data
   *   Data to add to the views data.
   *
   * @see \hook_views_data()
   */
  public function addData(array $data) {
    $this->data = array_merge_recursive($this->data, $data);
  }

  /**
   * Get data.
   *
   * @return array
   *   Data.
   */
  public function getData(): array {
    return $this->data;
  }

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::VIEWS_DATA;
  }

}
