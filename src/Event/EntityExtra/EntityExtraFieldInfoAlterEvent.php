<?php

namespace Drupal\hook_event_dispatcher\Event\EntityExtra;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class EntityExtraFieldInfoAlterEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\EntityExtra
 */
class EntityExtraFieldInfoAlterEvent extends Event implements EventInterface {

  /**
   * Extra field info.
   *
   * @var array
   */
  private $info;

  /**
   * EntityExtraFieldInfoAlterEvent constructor.
   *
   * @param array $info
   *   Extra field info.
   */
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
   * Get the extra field info.
   *
   * @return array
   *   Extra field info.
   */
  public function getInfo() {
    return $this->info;
  }

}
