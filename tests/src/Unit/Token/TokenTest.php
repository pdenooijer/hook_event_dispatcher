<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Token;

use Drupal\hook_event_dispatcher\Value\Token;
use PHPUnit\Framework\TestCase;

/**
 * Class TokenTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Token
 *
 * @group hook_event_dispatcher
 */
class TokenTest extends TestCase {

  /**
   * Test Token invalid type exception.
   */
  public function testTokenInvalidTypeException() {
    $this->expectException(\UnexpectedValueException::class);
    Token::create(NULL, '', '');
  }

  /**
   * Test Token invalid token exception.
   */
  public function testTokenInvalidTokenException() {
    $this->expectException(\UnexpectedValueException::class);
    Token::create('', NULL, '');
  }

  /**
   * Test Token invalid token exception.
   */
  public function testTokenInvalidNameException() {
    $this->expectException(\UnexpectedValueException::class);
    Token::create('', '', NULL);
  }

  /**
   * Test Token invalid description exception.
   */
  public function testTokenInvalidDescriptionException() {
    $this->expectException(\UnexpectedValueException::class);
    Token::create('', '', '')->setDescription(NULL);
  }

}
