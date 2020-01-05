<?php

namespace Drupal\core_event_dispatcher\ValueObject;

use Drupal\Component\Render\MarkupInterface;
use UnexpectedValueException;
use function is_string;

/**
 * Token ValueObject.
 *
 * Convenience object to handle the integrity and assembly of token types.
 */
final class TokenType {

  /**
   * Type.
   *
   * @var string
   */
  private $type;
  /**
   * Name.
   *
   * @var string
   */
  private $name;
  /**
   * Description.
   *
   * @var string|\Drupal\Component\Render\MarkupInterface
   */
  private $description;
  /**
   * Needs data.
   *
   * @var string
   */
  private $needsData;

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
   * @param string|\Drupal\Component\Render\MarkupInterface $name
   *   The print-able name of the type.
   *
   * @return self
   *   A new instance.
   *
   * @throws \UnexpectedValueException
   */
  public static function create(string $type, $name): self {
    $instance = new self();
    if (!is_string($name) && !$name instanceof MarkupInterface) {
      throw new UnexpectedValueException('Name should be a string or an instance of MarkupInterface');
    }
    $instance->type = $type;
    $instance->name = $name;
    return $instance;
  }

  /**
   * Set description and return a new instance.
   *
   * @param string|\Drupal\Component\Render\MarkupInterface $description
   *   The description of the token type.
   *
   * @return self
   *   A new instance with the description.
   *
   * @throws \UnexpectedValueException
   */
  public function setDescription($description): self {
    if (!is_string($description) && !$description instanceof MarkupInterface) {
      throw new UnexpectedValueException('Description should be a string or an instance of MarkupInterface');
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
  public function setNeedsData(string $needsData): self {
    $clone = clone $this;
    $clone->needsData = $needsData;
    return $clone;
  }

  /**
   * Getter.
   *
   * @return string|\Drupal\Component\Render\MarkupInterface|null
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
  public function getNeedsData(): ?string {
    return $this->needsData;
  }

  /**
   * Getter.
   *
   * @return string
   *   The token type like 'node'.
   */
  public function getType(): string {
    return $this->type;
  }

  /**
   * Getter.
   *
   * @return string
   *   The token type label, like 'The Node type'.
   */
  public function getName(): string {
    return $this->name;
  }

}
