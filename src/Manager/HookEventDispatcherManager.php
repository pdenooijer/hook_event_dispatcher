<?php

namespace Drupal\hook_event_dispatcher\Manager;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class HookEventDispatcherManager.
 *
 * @package Drupal\hook_event_dispatcher\Manager
 *
 * Wrapper class for the external dispatcher dependency. If this ever changes
 * we only have to change it once.
 */
final class HookEventDispatcherManager {

  /**
   * The event dispatcher.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  private $eventDispatcher;

  /**
   * EntityDispatcherManager constructor.
   *
   * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher
   *   The event dispatcher.
   */
  public function __construct(EventDispatcherInterface $eventDispatcher) {
    $this->eventDispatcher = $eventDispatcher;
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
