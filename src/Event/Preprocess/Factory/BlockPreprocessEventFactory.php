<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\BlockPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\BlockEventVariables;

/**
 * Class BlockPreprocessEventFactory.
 */
final class BlockPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables) {
    return new BlockPreprocessEvent(new BlockEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook() {
    return BlockPreprocessEvent::getHook();
  }

}
