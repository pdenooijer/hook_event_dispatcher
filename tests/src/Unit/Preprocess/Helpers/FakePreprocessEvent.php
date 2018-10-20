<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers;

use Drupal\hook_event_dispatcher\Event\Preprocess\AbstractPreprocessEvent;

/**
 * Class FakePreprocessEvent.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Preprocess\Helpers
 */
final class FakePreprocessEvent extends AbstractPreprocessEvent {

  /**
   * {@inheritdoc}
   */
  public static function getHook() {
    return '';
  }

}
