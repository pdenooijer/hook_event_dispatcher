<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Token;

use Drupal\core_event_dispatcher\ValueObject\Token;
use Drupal\Tests\UnitTestCase;
use UnexpectedValueException;

/**
 * Class TokenTest.
 *
 * @group hook_event_dispatcher
 */
class TokenTest extends UnitTestCase {

  /**
   * Test Token invalid token exception.
   */
  public function testTokenInvalidNameException(): void {
    $this->expectException(UnexpectedValueException::class);
    Token::create('', '', NULL);
  }

  /**
   * Test Token invalid description exception.
   */
  public function testTokenInvalidDescriptionException(): void {
    $this->expectException(UnexpectedValueException::class);
    Token::create('', '', '')->setDescription(NULL);
  }

}
