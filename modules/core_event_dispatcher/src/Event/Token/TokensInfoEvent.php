<?php

namespace Drupal\core_event_dispatcher\Event\Token;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\core_event_dispatcher\ValueObject\Token;
use Drupal\core_event_dispatcher\ValueObject\TokenType;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class TokensInfoEvent.
 *
 * @see hook_token_info
 */
final class TokensInfoEvent extends Event implements EventInterface {

  /**
   * Token types.
   *
   * @var array
   */
  private $tokenTypes = [];
  /**
   * Tokens.
   *
   * @var array
   */
  private $tokens = [];

  /**
   * Add token type.
   *
   * @param \Drupal\core_event_dispatcher\ValueObject\TokenType $type
   *   The token type.
   */
  public function addTokenType(TokenType $type): void {
    $this->tokenTypes[$type->getType()] = [
      'name' => $type->getName(),
      'description' => $type->getDescription(),
      'needs-data' => $type->getNeedsData(),
    ];
  }

  /**
   * Add token.
   *
   * @param \Drupal\core_event_dispatcher\ValueObject\Token $type
   *   The token.
   */
  public function addToken(Token $type): void {
    $this->tokens[$type->getType()][$type->getToken()] = [
      'name' => $type->getName(),
      'description' => $type->getDescription(),
      'dynamic' => $type->isDynamic(),
    ];
  }

  /**
   * Getter.
   *
   *  An associative array of token types (groups). Each token type is
   *  an associative array with the following components:
   *  - name: The translated human-readable short name of the token type.
   *  - description (optional): A translated longer description of the token
   *    type.
   *  - needs-data: The type of data that must be provided to
   *    \Drupal\Core\Utility\Token::replace() in the $data argument (i.e., the
   *    key name in $data) in order for tokens of this type to be used in the
   *    $text being processed. For instance, if the token needs a node object,
   *    'needs-data' should be 'node', and to use this token in
   *    \Drupal\Core\Utility\Token::replace(), the caller needs to supply a
   *    node object as $data['node']. Some token data can also be supplied
   *    indirectly; for instance, a node object in $data supplies a user object
   *    (the author of the node), allowing user tokens to be used when only
   *    a node data object is supplied.
   *
   * @return array
   *   All the different token types.
   */
  public function getTokenTypes(): array {
    return $this->tokenTypes;
  }

  /**
   * Getter.
   *
   * An associative array of tokens. The outer array is keyed by the
   * group name (the same key as in the types array). Within each group of
   * tokens, each token item is keyed by the machine name of the token, and
   * each token item has the following components:
   * - name: The translated human-readable short name of the token.
   * - description (optional): A translated longer description of the token.
   * - type (optional): A 'needs-data' data type supplied by this token, which
   *   should match a 'needs-data' value from another token type. For example,
   *   the node author token provides a user object, which can then be used
   *   for token replacement data in \Drupal\Core\Utility\Token::replace()
   *   without having to supply a separate user object.
   *
   * @return array
   *   The tokens.
   */
  public function getTokens(): array {
    return $this->tokens;
  }

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::TOKEN_INFO;
  }

}
