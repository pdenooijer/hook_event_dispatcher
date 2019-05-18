<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

use function array_key_exists;

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
  public function get(string $name, $default = NULL) {
    return array_key_exists($name, $this->variables) ? $this->variables[$name] : $default;
  }

  /**
   * Set a variable to a given value.
   *
   * @param string $name
   *   Variable name.
   * @param mixed $value
   *   Variable value.
   */
  public function set(string $name, $value = NULL): void {
    $this->variables[$name] = $value;
  }

  /**
   * Remove a given variable.
   *
   * @param string $name
   *   Variable name.
   */
  public function remove(string $name): void {
    unset($this->variables[$name]);
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
    return $this->variables[$name];
  }

}
