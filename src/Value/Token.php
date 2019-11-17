<?php

namespace Drupal\hook_event_dispatcher\Value;

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
   * @return \Drupal\hook_event_dispatcher\Value\Token
   *   Creates a new token.
   *
   * @throws \UnexpectedValueException
   */
  public static function create($type, $token, $name) {
    $instance = new self();
    if (!is_string($type)) {
      throw new UnexpectedValueException('Type should be a string');
    }
    if (!is_string($token)) {
      throw new UnexpectedValueException('Token should be a string');
    }
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
   * @param string $description
   *   The description of the token type.
   *
   * @return \Drupal\hook_event_dispatcher\Value\Token
   *   New instance with the given description.
   *
   * @throws \UnexpectedValueException
   */
  public function setDescription($description) {
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
   * @return \Drupal\hook_event_dispatcher\Value\Token
   *   New instance with the given dynamic.
   */
  public function setDynamic($dynamic) {
    $clone = clone $this;
    $clone->dynamic = $dynamic;
    return $clone;
  }

  /**
   * Getter.
   *
   * @return string|MarkupInterface|null
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
  public function getType() {
    return $this->type;
  }

  /**
   * Getter.
   *
   * @return string|MarkupInterface
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
  public function getToken() {
    return $this->token;
  }

  /**
   * Getter.
   *
   * @return bool
   *   Whether or not the token is dynamic.
   */
  public function isDynamic() {
    return $this->dynamic;
  }

}
