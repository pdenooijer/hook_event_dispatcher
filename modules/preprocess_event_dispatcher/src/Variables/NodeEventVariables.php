<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

/**
 * Class NodeEventVariables.
 */
class NodeEventVariables extends AbstractEntityEventVariables {

  /**
   * Get the node.
   *
   * @return \Drupal\node\Entity\Node
   *   The node.
   */
  public function getNode() {
    return $this->variables['node'];
  }

  /**
   * {@inheritdoc}
   */
  public function getEntity() {
    return $this->getNode();
  }

}
