<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers;

use BadMethodCallException;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use function count;
use function end;
use function key;

/**
 * Class SpyEventDispatcher.
 */
final class SpyEventDispatcher implements EventDispatcherInterface {

  /**
   * Events keyed by event name.
   *
   * @var \Symfony\Component\EventDispatcher\Event[]
   */
  private $events = [];

  /**
   * Event count.
   *
   * @var int
   */
  private $count = 1;

  /**
   * Set the expected event count.
   *
   * @param int $count
   *   Event count.
   */
  public function setExpectedEventCount($count) {
    $this->count = $count;
  }

  /**
   * Mocking an event dispatch, saving the event.
   *
   * {@inheritdoc}
   */
  public function dispatch($eventName, Event $event = NULL) {
    if (count($this->events) === $this->count) {
      throw new BadMethodCallException("SpyEventDispatcher got called more then {$this->count} time(s)");
    }

    $this->events[$eventName] = $event;
  }

  /**
   * Get the last event name.
   *
   * @return string
   *   Last event name.
   */
  public function getLastEventName() {
    end($this->events);
    return key($this->events);
  }

  /**
   * Get the last event.
   *
   * @return \Symfony\Component\EventDispatcher\Event
   *   Last event.
   */
  public function getLastEvent() {
    return end($this->events);
  }

  /**
   * Get the events keyed by event name.
   *
   * @return \Symfony\Component\EventDispatcher\Event[]
   *   Events keyed by event name.
   */
  public function getEvents() {
    return $this->events;
  }

  /**
   * Mock.
   *
   * @inheritdoc
   */
  public function addListener($eventName, $listener, $priority = 0) {
    throw new BadMethodCallException('This spy does not support this call');
  }

  /**
   * Mock.
   *
   * @inheritdoc
   */
  public function addSubscriber(EventSubscriberInterface $subscriber) {
    throw new BadMethodCallException('This spy does not support this call');
  }

  /**
   * Mock.
   *
   * @inheritdoc
   */
  public function removeListener($eventName, $listener) {
    throw new BadMethodCallException('This spy does not support this call');
  }

  /**
   * Mock.
   *
   * @inheritdoc
   */
  public function removeSubscriber(EventSubscriberInterface $subscriber) {
    throw new BadMethodCallException('This spy does not support this call');
  }

  /**
   * Mock.
   *
   * @inheritdoc
   */
  public function getListeners($eventName = NULL) {
    throw new BadMethodCallException('This spy does not support this call');
  }

  /**
   * Mock.
   *
   * @inheritdoc
   */
  public function getListenerPriority($eventName, $listener) {
    throw new BadMethodCallException('This spy does not support this call');
  }

  /**
   * Mock.
   *
   * @inheritdoc
   */
  public function hasListeners($eventName = NULL) {
    throw new BadMethodCallException('This spy does not support this call');
  }

}
