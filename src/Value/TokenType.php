<?php

namespace Drupal\hook_event_dispatcher\Value;

use Drupal\Component\Render\MarkupInterface;

/**
 * Token ValueObject.
 *
 * Convenience object to handle the integrity and assembly of token types.
 */
final class TokenType {

  private $description;
  private $needsData;
  private $type;
  private $name;

  /**
   * Use create function instead.
   */
  private function __construct() {
  }

  /**
   * Token type factory.
   *
   * @param string $type
   *   The group name, like 'node'.
   * @param string|MarkupInterface $name
   *   The print-able name of the type.
   *
   * @return self
   *   A new instance.
   */
  public static function create($type, $name) {
    $instance = new self();
    if (!is_string($type)) {
      throw new \UnexpectedValueException('Type should be a string');
    }
    if (!is_string($name) && !$name instanceof MarkupInterface) {
      throw new \UnexpectedValueException('Name should be a string or an instance of MarkupInterface');
    }
    $instance->type = $type;
    $instance->name = $name;
    return $instance;
  }

  /**
   * Set description and return a new instance.
   *
   * @param string $description
   *   The description of the token type.
   *
   * @return self
   *   A new instance with the description.
   */
  public function setDescription($description) {
    if (!is_string($description) && !$description instanceof MarkupInterface) {
      throw new \UnexpectedValueException('Description should be a string or an instance of MarkupInterface');
    }
    $clone = clone $this;
    $clone->description = $description;
    return $clone;
  }

  /**
   * Set the needs data and return a new instance.
   *
   * @param string $needsData
   *   The needs data.
   *
   * @return self
   *   A new instance with the needs data property.
   */
  public function setNeedsData($needsData) {
    if ($needsData && !is_string($needsData)) {
      throw new \UnexpectedValueException('NeedsData should be a string');
    }
    $clone = clone $this;
    $clone->needsData = $needsData;
    return $clone;
  }

  /**
   * Getter.
   *
   * @return string|null
   *   The description.
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * Getter.
   *
   * @return string|null
   *   The needs data property.
   */
  public function getNeedsData() {
    return $this->needsData;
  }

  /**
   * Getter.
   *
   * @return string
   *   The token type like 'node'.
   */
  public function getType() {
    return $this->type;
  }

  /**
   * Getter.
   *
   * @return string
   *   The token type label, like 'The Node type'.
   */
  public function getName() {
    return $this->name;
  }

}
