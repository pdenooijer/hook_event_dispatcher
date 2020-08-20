<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

use Drupal\block\BlockInterface;
use Drupal\block_content\BlockContentInterface;

/**
 * Class BlockEventVariables.
 */
class BlockEventVariables extends AbstractEventVariables {

  /**
   * Get the block.
   *
   * @return \Drupal\block\BlockInterface
   *   The block.
   */
  public function getBlock(): BlockInterface {
    return $this->variables['block'];
  }

  /**
   * Get the block identifier.
   *
   * @return string
   *   Identifier for the block.
   */
  public function getId(): string {
    return $this->variables['elements']['#id'];
  }

  /**
   * Get the content for a given child.
   *
   * @param string $childName
   *   Name of the child.
   *
   * @return array
   *   Content of the child or [].
   */
  public function getContentChild(string $childName): array {
    return $this->variables['content'][$childName] ?? [];
  }

  /**
   * Get the block content.
   *
   * @return null|\Drupal\block_content\BlockContentInterface
   *   Block Content Entity or NULL.
   */
  public function getBlockContent(): ?BlockContentInterface {
    return $this->variables['content']['#block_content'] ?? NULL;
  }

}
