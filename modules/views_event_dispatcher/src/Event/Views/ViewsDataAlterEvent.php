<?php

namespace Drupal\views_event_dispatcher\Event\Views;

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
  public function &getData(): array {
    return $this->data;
  }

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::VIEWS_DATA_ALTER;
  }

}
