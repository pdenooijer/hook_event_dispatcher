<?php

namespace Drupal\Tests\preprocess_event_dispatcher\Unit;

use Drupal\node\NodeInterface;
use Drupal\preprocess_event_dispatcher\Variables\PageEventVariables;
use PHPUnit\Framework\TestCase;
use Mockery;
use stdClass;

/**
 * Class PageTest.
 *
 * @group preprocess_event_dispatcher
 */
final class PageTest extends TestCase {

  /**
   * Test the getter.
   */
  public function testGet(): void {
    $vars = [];
    $vars['page']['test'] = TRUE;
    $vars['page']['array'] = ['array key' => 1];
    $vars['page']['object'] = new stdClass();
    $page = new PageEventVariables($vars);
    self::assertTrue($page->get('test'));
    self::assertArrayHasKey('array key', $page->get('array'));
    self::assertInstanceOf(stdClass::class, $page->get('object'));
    self::assertFalse($page->get('doesNotExists', FALSE));
  }

  /**
   * Test the setter.
   */
  public function testSet(): void {
    $vars = [];
    $page = new PageEventVariables($vars);
    $page->set('test', TRUE);
    $page->set('array', ['array key' => 1]);
    $page->set('object', new stdClass());
    self::assertTrue($page->get('test'));
    self::assertArrayHasKey('array key', $page->get('array'));
    self::assertInstanceOf(stdClass::class, $page->get('object'));
    $page->set('null');
    self::assertNull($page->get('null'));
  }

  /**
   * The the vars by ref.
   */
  public function testVarByRef(): void {
    $vars = [];
    $page = new PageEventVariables($vars);
    $vars['page']['test'] = TRUE;
    $vars['page']['array'] = ['array key' => 1];
    $vars['page']['object'] = new stdClass();
    self::assertTrue($page->get('test'));
    self::assertArrayHasKey('array key', $page->get('array'));
    self::assertInstanceOf(stdClass::class, $page->get('object'));
  }

  /**
   * Test is node page.
   */
  public function testIsNodePage(): void {
    $vars = [];
    $page = new PageEventVariables($vars);
    self::assertFalse($page->isNodePage());
    $vars['node'] = new stdClass();
    self::assertFalse($page->isNodePage());
    $vars['node'] = Mockery::mock(NodeInterface::class);
    self::assertTrue($page->isNodePage());
  }

  /**
   * Test getNode() call.
   */
  public function testGetNode(): void {
    $vars = [];
    $page = new PageEventVariables($vars);
    self::assertNull($page->getNode());
    $page->set('node', new stdClass());
    self::assertNull($page->getNode());
    $vars['node'] = Mockery::mock(NodeInterface::class);
    self::assertInstanceOf(NodeInterface::class, $page->getNode());
  }

  /**
   * Test getting a var by ref and changing it.
   */
  public function testGetVarByRef(): void {
    $vars = [];
    $vars['page']['test'] = 'test';
    $page = new PageEventVariables($vars);
    $test = &$page->getByReference('test');
    self::assertSame('test', $test);
    $test = 'OtherTest';
    self::assertSame('OtherTest', $page->get('test'));
    self::assertSame('OtherTest', $vars['page']['test']);
  }

  /**
   * Test getting root variables by reference.
   */
  public function testGetRootVariablesByReference(): void {
    $vars = [];
    $vars['test'] = 'something';
    $page = new PageEventVariables($vars);
    $retrievedVars = &$page->getRootVariablesByReference();
    self::assertSame($vars, $retrievedVars);

    $retrievedVars['test2'] = 'other';
    self::assertSame($vars, $retrievedVars);
    self::assertSame($vars, $page->getRootVariablesByReference());
  }

  /**
   * Test add cache context.
   */
  public function testAddCacheContext(): void {
    $vars = [];
    $page = new PageEventVariables($vars);
    $page->addCacheContext('url.path');

    $expectedVars = [];
    $expectedVars['#cache']['contexts'][] = 'url.path';
    self::assertSame($expectedVars, $vars);
  }

}
