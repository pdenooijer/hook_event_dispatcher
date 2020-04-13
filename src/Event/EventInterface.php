<?php

namespace Drupal\hook_event_dispatcher\Event;

/**
 * Interface EntityEventInterface.
 */
interface EventInterface {

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType(): string;

}
