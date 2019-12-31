<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

use Drupal\Core\Entity\EntityInterface;
use Drupal\node\NodeInterface;

/**
 * Class NodeEventVariables.
 */
class NodeEventVariables extends AbstractEntityEventVariables {

  /**
   * Get the node.
   *
   * @return \Drupal\node\NodeInterface
   *   The node.
   */
  public function getNode(): NodeInterface {
    return $this->variables['node'];
  }

  /**
   * {@inheritdoc}
   */
  public function getEntity(): EntityInterface {
    return $this->getNode();
  }

}
