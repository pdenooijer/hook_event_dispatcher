<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

use Drupal\node\NodeInterface;

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
    return isset($this->variables['node']) && $this->variables['node'] instanceof NodeInterface;
  }

  /**
   * Get the node of the page.
   *
   * @return \Drupal\node\NodeInterface|null
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
   * Set a given page variable.
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

  /**
   * Remove a given page variable.
   *
   * @param string $name
   *   Name.
   *
   * @return $this
   *   Page
   */
  public function remove($name) {
    unset($this->variables['page'][$name]);
    return $this;
  }

  /**
   * Get a variable with a given name by reference.
   *
   * @param string $name
   *   Variable name.
   *
   * @return mixed
   *   Reference for the variable.
   */
  public function &getByReference($name) {
    return $this->variables['page'][$name];
  }

  /**
   * Get the complete $variables of the page template.
   *
   * @return mixed
   *   Reference to all variables of the page template.
   */
  public function &getRootVariablesByReference() {
    return $this->variables;
  }

  /**
   * Add a cache context to the page template.
   *
   * @param string $context
   *   A cache context such as 'url.path'.
   *
   * @return $this
   *   PageEventVariables
   */
  public function addCacheContext($context) {
    $this->variables['#cache']['contexts'][] = $context;
    return $this;
  }

}
