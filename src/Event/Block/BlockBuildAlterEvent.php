<?php

namespace Drupal\hook_event_dispatcher\Event\Block;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class EntityInsertEvent.
 */
class BlockBuildAlterEvent extends BaseBlockEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::BLOCK_BUILD_ALTER;
  }

}
