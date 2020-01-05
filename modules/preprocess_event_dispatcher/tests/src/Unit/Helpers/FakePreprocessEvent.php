<?php

namespace Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers;

use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;

/**
 * Class FakePreprocessEvent.
 */
final class FakePreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook(): string {
    return '';
  }

}
