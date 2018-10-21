<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class NodeEventVariables.
 */
class NodeEventVariables extends ContentEntityEventVariables {

  /**
   * Get the node.
   *
   * @return \Drupal\node\Entity\Node
   *   The node.
   */
  public function getNode() {
    return $this->variables['node'];
  }

}
