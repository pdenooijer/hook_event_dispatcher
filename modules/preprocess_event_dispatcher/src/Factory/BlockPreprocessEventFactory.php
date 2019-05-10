<?php

namespace Drupal\preprocess_event_dispatcher\Factory;

use Drupal\preprocess_event_dispatcher\Event\BlockPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\BlockEventVariables;

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
