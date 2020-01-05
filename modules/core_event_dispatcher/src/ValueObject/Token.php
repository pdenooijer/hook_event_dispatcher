<?php

namespace Drupal\core_event_dispatcher\ValueObject;

use Drupal\Component\Render\MarkupInterface;
use UnexpectedValueException;
use function is_string;

/**
 * Token ValueObject.
 *
 * Convenience object to handle the integrity and assembly of tokens.
 */
final class Token {

  /**
   * Type.
   *
   * @var string
   */
  private $type;
  /**
   * Token.
   *
   * @var string
   */
  private $token;
  /**
   * Description.
   *
   * @var string
   */
  private $description;
  /**
   * Name.
   *
   * @var string|\Drupal\Component\Render\MarkupInterface
   */
  private $name;
  /**
   * Is a dynamic field.
   *
   * @var bool
   */
  private $dynamic = FALSE;

  /**
   * Use create function instead.
   */
  private function __construct() {
  }

  /**
   * Token factory function.
   *
   * @param string $type
   *   The group name, like 'node'.
   * @param string $token
   *   The token, like 'url' or 'id'.
   * @param string|\Drupal\Component\Render\MarkupInterface $name
   *   The print-able name of the type.
   *
   * @return \Drupal\core_event_dispatcher\ValueObject\Token
   *   Creates a new token.
   *
   * @throws \UnexpectedValueException
   */
  public static function create(string $type, string $token, $name): self {
    $instance = new self();
    if (!is_string($name) && !$name instanceof MarkupInterface) {
      throw new UnexpectedValueException('Name should be a string or an instance of MarkupInterface');
    }
    $instance->type = $type;
    $instance->token = $token;
    $instance->name = $name;
    return $instance;
  }

  /**
   * Set description and return a new instance.
   *
   * @param string|\Drupal\Component\Render\MarkupInterface $description
   *   The description of the token type.
   *
   * @return \Drupal\core_event_dispatcher\ValueObject\Token
   *   New instance with the given description.
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
   * Set whether or not the token is dynamic.
   *
   * @param bool $dynamic
   *   TRUE if the token is dynamic.
   *
   * @return \Drupal\core_event_dispatcher\ValueObject\Token
   *   New instance with the given dynamic.
   */
  public function setDynamic(bool $dynamic): self {
    $clone = clone $this;
    $clone->dynamic = $dynamic;
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
   * @return string
   *   The type like 'node'.
   */
  public function getType(): string {
    return $this->type;
  }

  /**
   * Getter.
   *
   * @return string|\Drupal\Component\Render\MarkupInterface
   *   The label of the token.
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Getter.
   *
   * @return string
   *   The token name like 'url'.
   */
  public function getToken(): string {
    return $this->token;
  }

  /**
   * Getter.
   *
   * @return bool
   *   Whether or not the token is dynamic.
   */
  public function isDynamic(): bool {
    return $this->dynamic;
  }

}
