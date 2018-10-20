<?php

namespace Drupal\hook_event_dispatcher\Event\Block;

use Drupal\Core\Block\BlockPluginInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class BaseBlockEvent.
 */
abstract class BaseBlockEvent extends Event implements EventInterface {

  /**
   * The build array.
   *
   * @var array
   */
  protected $build;
  /**
   * The block.
   *
   * @var \Drupal\Core\Block\BlockPluginInterface
   */
  protected $block;

  /**
   * BaseBlockEvent constructor.
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
  public function &getBuild() {
    return $this->build;
  }

  /**
   * Set the block.
   *
   * @param array $build
   *   The build array.
   *
   * @deprecated This is not needed, the form is passed by reference.
   */
  public function setBuild(array $build) {
    $this->build = $build;
  }

  /**
   * Get the block.
   *
   * @return \Drupal\Core\Block\BlockPluginInterface
   *   The block object.
   */
  public function getBlock() {
    return $this->block;
  }

}
