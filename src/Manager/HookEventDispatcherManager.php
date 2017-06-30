<?php

namespace Drupal\hook_event_dispatcher\Manager;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class HookEventDispatcherManager.
 *
 * @package Drupal\hook_event_dispatcher\Manager
 */
class HookEventDispatcherManager {

  /**
   * The event dispatcher.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $eventDispatcher;

  /**
   * EntityDispatcherManager constructor.
   *
   * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $event_dispatcher
   *   The event dispatcher.
   */
  public function __construct(EventDispatcherInterface $event_dispatcher) {
    $this->eventDispatcher = $event_dispatcher;
  }

  /**
   * Registers an event dispatcher for given entity.
   *
   * @param \Drupal\hook_event_dispatcher\Event\EventInterface $event
   *   The event.
   *
   * @return \Symfony\Component\EventDispatcher\Event
   *   The event.
   */
  public function register(EventInterface $event) {
    return $this->eventDispatcher->dispatch($event->getDispatcherType(), $event);
  }

}
