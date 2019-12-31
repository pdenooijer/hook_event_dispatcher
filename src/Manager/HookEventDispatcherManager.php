<?php

namespace Drupal\hook_event_dispatcher\Manager;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class HookEventDispatcherManager.
 *
 * Wrapper class for the external dispatcher dependency. If this ever changes
 * we only have to change it once.
 */
final class HookEventDispatcherManager implements HookEventDispatcherManagerInterface {

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
   * {@inheritdoc}
   */
  public function register(EventInterface $event): Event {
    return $this->eventDispatcher->dispatch($event->getDispatcherType(), $event);
  }

}
