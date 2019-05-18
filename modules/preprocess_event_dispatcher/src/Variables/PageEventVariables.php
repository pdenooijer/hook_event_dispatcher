<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

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
  public function isNodePage(): bool {
    return isset($this->variables['node']) && $this->variables['node'] instanceof NodeInterface;
  }

  /**
   * Get the node of the page.
   *
   * @return \Drupal\node\NodeInterface|null
   *   Drupal node.
   */
  public function getNode(): ?NodeInterface {
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
  public function get(string $name, $default = NULL) {
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
   */
  public function set(string $name, $value = NULL): void {
    $this->variables['page'][$name] = $value;
  }

  /**
   * Remove a given page variable.
   *
   * @param string $name
   *   Name.
   */
  public function remove(string $name): void {
    unset($this->variables['page'][$name]);
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
  public function &getByReference(string $name) {
    return $this->variables['page'][$name];
  }

  /**
   * Get the complete $variables of the page template.
   *
   * @return array
   *   Reference to all variables of the page template.
   */
  public function &getRootVariablesByReference(): array {
    return $this->variables;
  }

  /**
   * Add a cache context to the page template.
   *
   * @param string $context
   *   A cache context such as 'url.path'.
   */
  public function addCacheContext(string $context): void {
    $this->variables['#cache']['contexts'][] = $context;
  }

}
