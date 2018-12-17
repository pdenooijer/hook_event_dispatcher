<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class BlockEventVariables.
 */
class BlockEventVariables extends AbstractEventVariables {

  /**
   * Get the block.
   *
   * @return \Drupal\block\Entity\Block
   *   The block.
   */
  public function getBlock() {
    return $this->variables['block'];
  }

  /**
   * Get the block identifier.
   *
   * @return string
   *   Identifier for the block.
   */
  public function getId() {
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
  public function getContentChild($childName) {
    if (isset($this->variables['content'][$childName])) {
      return $this->variables['content'][$childName];
    }
    return [];
  }

}
