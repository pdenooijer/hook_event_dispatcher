<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Token;

use Drupal\hook_event_dispatcher\Value\Token;
use Drupal\Tests\UnitTestCase;
use UnexpectedValueException;

/**
 * Class TokenTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Token
 *
 * @group hook_event_dispatcher
 */
class TokenTest extends UnitTestCase {

  /**
   * Test Token invalid token exception.
   */
  public function testTokenInvalidNameException(): void {
    $this->setExpectedException(UnexpectedValueException::class);
    Token::create('', '', NULL);
  }

  /**
   * Test Token invalid description exception.
   */
  public function testTokenInvalidDescriptionException(): void {
    $this->setExpectedException(UnexpectedValueException::class);
    Token::create('', '', '')->setDescription(NULL);
  }

}
