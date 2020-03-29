<?php

namespace Drupal\toolbar_event_dispatcher\Event\Toolbar;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ToolbarAlterEvent.
 */
class ToolbarAlterEvent extends Event implements EventInterface {

  /**
   * The toolbar items.
   *
   * @var array
   */
  private $items;

  /**
   * ToolbarAlterEvent constructor.
   *
   * @param array $items
   *   The toolbar items.
   */
  public function __construct(array &$items) {
    $this->items = &$items;
  }

  /**
   * Get the items by reference.
   *
   * @return array
   *   The items.
   */
  public function &getItems(): array {
    return $this->items;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::TOOLBAR_ALTER;
  }

}
