<?php

namespace Drupal\core_event_dispatcher\Event\Token;

use Drupal\Component\Render\MarkupInterface;
use Drupal\Core\Render\BubbleableMetadata;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;
use UnexpectedValueException;
use function is_string;

/**
 * Class TokensProvideEvent.
 *
 * @see hook_tokens
 */
final class TokensReplacementEvent extends Event implements EventInterface {

  /**
   * An associative array of replacement values.
   *
   * Keyed by the raw [type:token] strings from the original text.
   * The returned values must be either plain
   * text strings, or an object implementing MarkupInterface if they are
   * HTML-formatted.
   *
   * @var string[]|\Drupal\Component\Render\MarkupInterface[]
   */
  private $replacementValues = [];
  /**
   * Type.
   *
   * @var string
   */
  private $type;
  /**
   * Tokens.
   *
   * @var array
   */
  private $tokens;
  /**
   * Data.
   *
   * @var array
   */
  private $data;
  /**
   * Options.
   *
   * @var array
   */
  private $options;
  /**
   * Bubbleable meta data.
   *
   * @var \Drupal\Core\Render\BubbleableMetadata
   */
  private $bubbleableMetadata;

  /**
   * Constructor.
   *
   * @param string $type
   *   The machine-readable name of the type (group) of token being replaced,
   *   such as 'node', 'user', or another type defined by a hook_token_info()
   *   implementation.
   * @param array $tokens
   *   An array of tokens to be replaced. The keys are the machine-readable
   *   token names, and the values are the raw [type:token] strings that
   *   appeared in the
   *   original text.
   * @param array $data
   *   An associative array of data objects to be used when generating
   *   replacement values, as supplied in the $data parameter to
   *   \Drupal\Core\Utility\Token::replace().
   * @param array $options
   *   An associative array of options for token replacement; see
   *   \Drupal\Core\Utility\Token::replace() for possible values.
   * @param \Drupal\Core\Render\BubbleableMetadata $bubbleableMetadata
   *   The bubbleable metadata. Prior to invoking this hook,
   *   \Drupal\Core\Utility\Token::generate() collects metadata for all of the
   *   data objects in $data. For any data sources not in $data, but that are
   *   used by the token replacement logic, such as global configuration (e.g.,
   *   'system.site') and related objects (e.g., $node->getOwner()),
   *   implementations of this hook must add the corresponding metadata.
   */
  public function __construct(
    string $type,
    array $tokens,
    array $data,
    array $options,
    BubbleableMetadata $bubbleableMetadata
  ) {
    $this->type = $type;
    $this->tokens = $tokens;
    $this->data = $data;
    $this->options = $options;
    $this->bubbleableMetadata = $bubbleableMetadata;
  }

  /**
   * Getter.
   *
   * The machine-readable name of the type (group) of token being replaced,
   * such as 'node', 'user', or another type defined by a hook_token_info()
   * implementation.
   *
   * @return string
   *   The type.
   */
  public function getType(): string {
    return $this->type;
  }

  /**
   * Getter.
   *
   * An array of tokens to be replaced. The keys are the machine-readable
   * token names, and the values are the raw [type:token] strings that
   * appeared in the original text.
   *
   * @return array
   *   The tokens.
   */
  public function getTokens(): array {
    return $this->tokens;
  }

  /**
   * Getter for single data member.
   *
   * @param string $key
   *   The key for the additional token data, like 'node'.
   * @param mixed $default
   *   The default value, if data does not exists.
   *
   * @return mixed
   *   The value.
   */
  public function getData(string $key, $default = NULL) {
    return $this->data[$key] ?? $default;
  }

  /**
   * Getter.
   *
   * An associative array of data objects to be used when generating
   * replacement values, as supplied in the $data parameter to
   * \Drupal\Core\Utility\Token::replace().
   *
   * @return array
   *   The raw data given inside the hook_tokens.
   */
  public function getRawData(): array {
    return $this->data;
  }

  /**
   * Getter.
   *
   * An associative array of options for token replacement; see
   * \Drupal\Core\Utility\Token::replace() for possible values.
   *
   * @return array
   *   The raw options given inside the hook_tokens.
   */
  public function getOptions(): array {
    return $this->options;
  }

  /**
   * Getter.
   *
   * The bubbleable metadata. Prior to invoking this hook,
   * \Drupal\Core\Utility\Token::generate() collects metadata for all of the
   * data objects in $data. For any data sources not in $data, but that are
   * used by the token replacement logic, such as global configuration (e.g.,
   * 'system.site') and related objects (e.g., $node->getOwner()),
   * implementations of this hook must add the corresponding metadata.
   * For example:
   *
   * @return \Drupal\Core\Render\BubbleableMetadata
   *   The metadata.
   */
  public function getBubbleableMetadata(): BubbleableMetadata {
    return $this->bubbleableMetadata;
  }

  /**
   * An associative array of replacement values.
   *
   * Keyed by the raw [type:token] strings from the original text.
   * The returned values must be either plain
   * text strings, or an object implementing MarkupInterface if they are
   * HTML-formatted.
   *
   * @return string[]|\Drupal\Component\Render\MarkupInterface[]
   *   The replacement values for the token.
   */
  public function getReplacementValues(): array {
    return $this->replacementValues;
  }

  /**
   * Set's a replacement value for a token.
   *
   * @param string $type
   *   The token type like 'node'.
   * @param string $token
   *   The name of the token, like 'url'.
   * @param string|\Drupal\Component\Render\MarkupInterface $replacement
   *   The replacement value.
   *
   * @throws \UnexpectedValueException
   */
  public function setReplacementValue(string $type, string $token, $replacement): void {
    if (!$this->forToken($type, $token)) {
      throw new UnexpectedValueException('Requested replacement is not requested');
    }
    if (!is_string($replacement) && !$replacement instanceof MarkupInterface) {
      throw new UnexpectedValueException('Replacement value should be a string or instanceof MarkupInterface');
    }
    $this->replacementValues["[$type:$token]"] = $replacement;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::TOKEN_REPLACEMENT;
  }

  /**
   * Check if the event is for the given token.
   *
   * @param string $type
   *   The token type like 'node'.
   * @param string $token
   *   The token type like 'url'.
   *
   * @return bool
   *   TRUE if there is one.
   */
  public function forToken(string $type, string $token): bool {
    return $this->type === $type && isset($this->tokens[$token]);
  }

}
