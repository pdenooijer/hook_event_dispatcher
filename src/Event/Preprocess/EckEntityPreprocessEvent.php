<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class EckEntityPreprocessEvent.
 */
final class EckEntityPreprocessEvent extends AbstractPreprocessEntityEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return 'eck_entity';
  }

}
