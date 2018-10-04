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
   * An array of events dispatched.
   *
   * @var \Symfony\Component\EventDispatcher\Event[]
   */
  private $eventArray = [];

  /**
   * An array of event names dispatched.
   *
   * @var array
   */
  private $eventNameArray = [];

  /**
   * Mocking an event dispatch, saving the event.
   *
   * @inheritdoc
   */
  public function dispatch($eventName, Event $event = NULL) {

    if (in_array($eventName, $this->eventNameArray) || in_array($event, $this->eventArray)) {
      throw new \BadMethodCallException('SpyEventDispatcher got called twice, for the same event');
    }
    $this->eventNameArray[] = $eventName;
    $this->eventArray[] = $event;
  }

  /**
   * Get the all event names.
   *
   * @return array
   *   All dispatched event name.
   */
  public function getEventNames() {
    return $this->eventNameArray;
  }

  /**
   * Get the all the dispatched events.
   *
   * @return array
   *   All dispatched events.
   */
  public function getEvents() {
    return $this->eventArray;
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
