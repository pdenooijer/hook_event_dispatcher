<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class AbstractEventVariables.
 *
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class AbstractEventVariables {

  /**
   * Variables.
   *
   * @var array
   */
  protected $variables;

  /**
   * Event Variables constructor.
   *
   * @param array $variables
   *   Event variables.
   */
  public function __construct(array &$variables) {
    $this->variables = &$variables;
  }

  /**
   * Get a variable with a given name, return default if it does not exist.
   *
   * @param string $name
   *   Variable name.
   * @param mixed|null $default
   *   Default value.
   *
   * @return mixed
   *   Value for variable BY VALUE.
   */
  public function get($name, $default = NULL) {
    return \array_key_exists($name, $this->variables) ? $this->variables[$name] : $default;
  }

  /**
   * Set a variable to a given value.
   *
   * @param string $name
   *   Variable name.
   * @param mixed $value
   *   Variable value.
   *
   * @return $this
   *   Event variables.
   */
  public function set($name, $value = NULL) {
    $this->variables[$name] = $value;
    return $this;
  }

  /**
   * Remove a given variable.
   *
   * @param string $name
   *   Variable name.
   *
   * @return $this
   *   Event variables.
   */
  public function remove($name) {
    unset($this->variables[$name]);
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
    return $this->variables[$name];
  }

}
