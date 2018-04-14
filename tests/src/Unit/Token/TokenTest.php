<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Token;

use Drupal\hook_event_dispatcher\Value\Token;
use Drupal\Tests\UnitTestCase;

/**
 * Class TokenTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Token
 *
 * @group hook_event_dispatcher
 */
class TokenTest extends UnitTestCase {

  /**
   * Test Token invalid type exception.
   */
  public function testTokenInvalidTypeException() {
    $this->setExpectedException(\UnexpectedValueException::class);
    Token::create(NULL, '', '');
  }

  /**
   * Test Token invalid token exception.
   */
  public function testTokenInvalidTokenException() {
    $this->setExpectedException(\UnexpectedValueException::class);
    Token::create('', NULL, '');
  }

  /**
   * Test Token invalid token exception.
   */
  public function testTokenInvalidNameException() {
    $this->setExpectedException(\UnexpectedValueException::class);
    Token::create('', '', NULL);
  }

  /**
   * Test Token invalid description exception.
   */
  public function testTokenInvalidDescriptionException() {
    $this->setExpectedException(\UnexpectedValueException::class);
    Token::create('', '', '')->setDescription(NULL);
  }

}
