<?php

namespace Drupal\hook_event_dispatcher\Event\EntityExtra;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;
use Symfony\Component\EventDispatcher\Event;

class EntityExtraFieldInfoAlterEvent extends Event implements EventInterface {

  /**
   * @var array
   */
  private $info;

  public function __construct(array &$info) {
    $this->info = &$info;
  }

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::ENTITY_EXTRA_FIELD_INFO_ALTER;
  }

  /**
   * @return array
   */
  public function getInfo() {
    return $this->info;
  }

}
