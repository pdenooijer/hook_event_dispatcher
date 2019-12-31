<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Manager;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class FakeEvent.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Manager
 */
class FakeEvent extends Event implements EventInterface {

  /**
   * Dispatcher type.
   *
   * @var string
   */
  private $dispatcherType;

  /**
   * FakeEvent constructor.
   *
   * @param string $dispatcherType
   *   Dispatcher type.
   */
  public function __construct($dispatcherType) {
    $this->dispatcherType = $dispatcherType;
  }

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType(): string {
    return $this->dispatcherType;
  }

}
