<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Token;

use Drupal\hook_event_dispatcher\Value\TokenType;
use Drupal\Tests\UnitTestCase;
use UnexpectedValueException;

/**
 * Class TokenTypeTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Token
 *
 * @group hook_event_dispatcher
 */
class TokenTypeTest extends UnitTestCase {

  /**
   * Test TokenType invalid name exception.
   */
  public function testTokenTypeInvalidNameException(): void {
    $this->setExpectedException(UnexpectedValueException::class);
    TokenType::create('', NULL);
  }

  /**
   * Test TokenType invalid description exception.
   */
  public function testTokenTypeInvalidDescriptionException(): void {
    $this->setExpectedException(UnexpectedValueException::class);
    TokenType::create('', '')->setDescription(NULL);
  }

}
