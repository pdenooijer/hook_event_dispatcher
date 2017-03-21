<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

use Drupal\node\Entity\Node;

/**
 * Class PageEventVariables.
 */
class PageEventVariables extends AbstractEventVariables {

  /**
   * Is the current page a rendering a node?.
   *
   * @return bool
   *   Is it?
   */
  public function isNodePage() {
    return isset($this->variables['node']) && $this->variables['node'] instanceof Node;
  }

  /**
   * Get the node of the page.
   *
   * @return Node|null
   *   Drupal node.
   */
  public function getNode() {
    if (!$this->isNodePage()) {
      return NULL;
    }

    return $this->variables['node'];
  }

  /**
   * Get the template var.
   *
   * @param string $name
   *   Name.
   * @param mixed $default
   *   Default.
   *
   * @return mixed
   *   Value
   */
  public function get($name, $default = NULL) {
    if (!isset($this->variables['page'][$name])) {
      return $default;
    }

    return $this->variables['page'][$name];
  }

  /**
   * Set page variables.
   *
   * @param string $name
   *   Name.
   * @param mixed $value
   *   Value.
   *
   * @return $this
   *   PageEventVariables
   */
  public function set($name, $value = NULL) {
    $this->variables['page'][$name] = $value;
    return $this;
  }

}
