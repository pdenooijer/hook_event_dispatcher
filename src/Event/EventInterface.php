<?php

namespace Drupal\hook_event_dispatcher\Event;


/**
 * Interface EntityEventInterface
 * @package Drupal\hook_event_dispatcher\Event
 */
interface EventInterface {

  public function getDispatcherType();

}