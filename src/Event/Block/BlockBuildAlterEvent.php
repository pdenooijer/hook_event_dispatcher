<?php

namespace Drupal\hook_event_dispatcher\Event\Block;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class EntityInsertEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Entity
 */
class BlockBuildAlterEvent extends BaseBlockEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::BLOCK_BUILD_ALTER;
  }

}
