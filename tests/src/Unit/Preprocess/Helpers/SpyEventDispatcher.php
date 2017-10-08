<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class SpyEventDispatcher.
 */
final class SpyEventDispatcher implements EventDispatcherInterface {

  /**
   * Event name.
   *
   * @var string
   */
  private $eventName;

  /**
   * Event.
   *
   * @var \Symfony\Component\EventDispatcher\Event
   */
  private $event;

  /**
   * Mocking an event dispatch, saving the event.
   *
   * @inheritdoc
   */
  public function dispatch($eventName, Event $event = NULL) {
    if ($this->eventName !== NULL || $this->event !== NULL) {
      throw new \BadMethodCallException('SpyEventDispatcher got called twice');
    }

    $this->eventName = $eventName;
    $this->event = $event;
  }

  /**
   * Get the last event name.
   *
   * @return string
   *   Last event name.
   */
  public function getLastEventName() {
    return $this->eventName;
  }

  /**
   * Get the last event.
   *
   * @return \Symfony\Component\EventDispatcher\Event
   *   Last event.
   */
  public function getLastEvent() {
    return $this->event;
  }

  /**
   * Mock.
   *
   * @inheritdoc
   */
  public function addListener($eventName, $listener, $priority = 0) {
    throw new \BadMethodCallException('This spy does not support this call');
  }

  /**
   * Mock.
   *
   * @inheritdoc
   */
  public function addSubscriber(EventSubscriberInterface $subscriber) {
    throw new \BadMethodCallException('This spy does not support this call');
  }

  /**
   * Mock.
   *
   * @inheritdoc
   */
  public function removeListener($eventName, $listener) {
    throw new \BadMethodCallException('This spy does not support this call');
  }

  /**
   * Mock.
   *
   * @inheritdoc
   */
  public function removeSubscriber(EventSubscriberInterface $subscriber) {
    throw new \BadMethodCallException('This spy does not support this call');
  }

  /**
   * Mock.
   *
   * @inheritdoc
   */
  public function getListeners($eventName = NULL) {
    throw new \BadMethodCallException('This spy does not support this call');
  }

  /**
   * Mock.
   *
   * @inheritdoc
   */
  public function getListenerPriority($eventName, $listener) {
    throw new \BadMethodCallException('This spy does not support this call');
  }

  /**
   * Mock.
   *
   * @inheritdoc
   */
  public function hasListeners($eventName = NULL) {
    throw new \BadMethodCallException('This spy does not support this call');
  }

}
