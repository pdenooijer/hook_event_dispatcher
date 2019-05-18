<?php

namespace Drupal\preprocess_event_dispatcher\Event;

/**
 * Class EckEntityPreprocessEvent.
 */
final class EckEntityPreprocessEvent extends AbstractPreprocessEntityEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook(): string {
    return 'eck_entity';
  }

}
