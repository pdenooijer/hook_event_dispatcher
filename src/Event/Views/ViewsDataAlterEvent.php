<?php

namespace Drupal\hook_event_dispatcher\Event\Views;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ViewsDataAlterEvent.
 */
final class ViewsDataAlterEvent extends Event implements EventInterface {

  /**
   * Data.
   *
   * @var array
   */
  private $data;

  /**
   * ViewsDataAlterEvent constructor.
   *
   * @param array $data
   *   Data.
   */
  public function __construct(array &$data) {
    $this->data = &$data;
  }

  /**
   * Get data by refence.
   *
   * @return array
   *   Data.
   */
  public function &getData() {
    return $this->data;
  }

  /**
   * Set data.
   *
   * @param array $data
   *   Data.
   */
  public function setData(array $data) {
    $this->data = $data;
  }

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::VIEWS_DATA_ALTER;
  }

}
