<?php

namespace Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers;

use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;

/**
 * Class FakePreprocessEvent.
 *
 * @package Drupal\Tests\preprocess_event_dispatcher\Preprocess\Helpers
 */
final class FakePreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return '';
  }

}
