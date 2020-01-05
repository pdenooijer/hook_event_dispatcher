<?php

namespace Drupal\core_event_dispatcher\Event\Block;

use Drupal\Core\Block\BlockPluginInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class BlockBuildAlterEvent.
 */
class BlockBuildAlterEvent extends Event implements EventInterface {

  /**
   * The build array.
   *
   * @var array
   */
  private $build;
  /**
   * The block.
   *
   * @var \Drupal\Core\Block\BlockPluginInterface
   */
  private $block;

  /**
   * BlockBuildAlterEvent constructor.
   *
   * @param array $build
   *   The build array.
   * @param \Drupal\Core\Block\BlockPluginInterface $block
   *   The block object.
   */
  public function __construct(array &$build, BlockPluginInterface $block) {
    $this->build = &$build;
    $this->block = $block;
  }

  /**
   * Get the build array.
   *
   * @return array
   *   The build array.
   */
  public function &getBuild(): array {
    return $this->build;
  }

  /**
   * Get the block.
   *
   * @return \Drupal\Core\Block\BlockPluginInterface
   *   The block object.
   */
  public function getBlock(): BlockPluginInterface {
    return $this->block;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::BLOCK_BUILD_ALTER;
  }

}
