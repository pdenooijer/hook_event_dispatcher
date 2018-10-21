<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\Manager\HookEventDispatcherManagerInterface;

/**
 * Class HookEventDispatcherManagerSpy.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit
 */
class HookEventDispatcherManagerSpy implements HookEventDispatcherManagerInterface {

  /**
   * The maximum amount of events that should register.
   *
   * @var int
   */
  private $maxEventCount = 1;
  /**
   * Event callbacks.
   *
   * @var array
   */
  private $eventCallbacks = [];
  /**
   * The amount of event registered.
   *
   * @var int
   */
  private $eventCount = 0;
  /**
   * Registered events.
   *
   * @var \Drupal\hook_event_dispatcher\Event\EventInterface[]
   */
  private $registeredEvents = [];

  /**
   * {@inheritdoc}
   *
   * @throws \Drupal\Tests\hook_event_dispatcher\Unit\TooManyEventsException
   */
  public function register(EventInterface $event) {
    $this->eventCount++;
    if ($this->eventCount > $this->maxEventCount) {
      throw new TooManyEventsException(
        "Got {$this->eventCount} events, but only {$this->maxEventCount} are allowed"
      );
    }
    $type = $event->getDispatcherType();
    $this->registeredEvents[$type] = $event;

    if (isset($this->eventCallbacks[$type])) {
      $this->eventCallbacks[$type]($event);
    }
  }

  /**
   * Set max event count.
   *
   * @param int $maxEventCount
   *   Event count.
   */
  public function setMaxEventCount($maxEventCount) {
    $this->maxEventCount = $maxEventCount;
  }

  /**
   * Set event callbacks.
   *
   * @param array $eventCallbacks
   *   Associative event callbacks array.
   */
  public function setEventCallbacks(array $eventCallbacks) {
    $this->eventCallbacks = $eventCallbacks;
  }

  /**
   * Getter.
   *
   * @param string $eventName
   *   Event name.
   *
   * @return \Drupal\hook_event_dispatcher\Event\EventInterface
   *   Registered event by name.
   */
  public function getRegisteredEvent($eventName) {
    if (!isset($this->registeredEvents[$eventName])) {
      throw new \InvalidArgumentException("The event '$eventName' was not registered");
    }
    return $this->registeredEvents[$eventName];
  }

}
