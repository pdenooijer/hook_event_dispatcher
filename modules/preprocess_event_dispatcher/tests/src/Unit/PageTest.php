<?php

namespace Drupal\Tests\preprocess_event_dispatcher\Unit;

use Drupal\node\NodeInterface;
use Drupal\preprocess_event_dispatcher\Variables\PageEventVariables;
use Drupal\Tests\UnitTestCase;
use Mockery;
use stdClass;

/**
 * Class PageTest.
 *
 * @group preprocess_event_dispatcher
 */
final class PageTest extends UnitTestCase {

  /**
   * Test the getter.
   */
  public function testGet(): void {
    $vars['page']['test'] = TRUE;
    $vars['page']['array'] = ['array key' => 1];
    $vars['page']['object'] = new stdClass();
    $page = new PageEventVariables($vars);
    $this->assertTrue($page->get('test'));
    $this->assertArrayHasKey('array key', $page->get('array'));
    $this->assertInstanceOf(stdClass::class, $page->get('object'));
    $this->assertFalse($page->get('doesNotExists', FALSE));
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
    $this->assertTrue($page->get('test'));
    $this->assertArrayHasKey('array key', $page->get('array'));
    $this->assertInstanceOf(stdClass::class, $page->get('object'));
    $page->set('null');
    $this->assertNull($page->get('null'));
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
    $this->assertTrue($page->get('test'));
    $this->assertArrayHasKey('array key', $page->get('array'));
    $this->assertInstanceOf(stdClass::class, $page->get('object'));
  }

  /**
   * Test is node page.
   */
  public function testIsNodePage(): void {
    $vars = [];
    $page = new PageEventVariables($vars);
    $this->assertFalse($page->isNodePage());
    $vars['node'] = new stdClass();
    $this->assertFalse($page->isNodePage());
    $vars['node'] = Mockery::mock(NodeInterface::class);
    $this->assertTrue($page->isNodePage());
  }

  /**
   * Test getNode() call.
   */
  public function testGetNode(): void {
    $vars = [];
    $page = new PageEventVariables($vars);
    $this->assertNull($page->getNode());
    $page->set('node', new stdClass());
    $this->assertNull($page->getNode());
    $vars['node'] = Mockery::mock(NodeInterface::class);
    $this->assertInstanceOf(NodeInterface::class, $page->getNode());
  }

  /**
   * Test getting a var by ref and changing it.
   */
  public function testGetVarByRef(): void {
    $vars['page']['test'] = 'test';
    $page = new PageEventVariables($vars);
    $test = &$page->getByReference('test');
    $this->assertSame('test', $test);
    $test = 'OtherTest';
    $this->assertSame('OtherTest', $page->get('test'));
    $this->assertSame('OtherTest', $vars['page']['test']);
  }

  /**
   * Test getting root variables by reference.
   */
  public function testGetRootVariablesByReference(): void {
    $vars['test'] = 'something';
    $page = new PageEventVariables($vars);
    $retrievedVars = &$page->getRootVariablesByReference();
    $this->assertSame($vars, $retrievedVars);

    $retrievedVars['test2'] = 'other';
    $this->assertSame($vars, $retrievedVars);
    $this->assertSame($vars, $page->getRootVariablesByReference());
  }

  /**
   * Test add cache context.
   */
  public function testAddCacheContext(): void {
    $vars = [];
    $page = new PageEventVariables($vars);
    $page->addCacheContext('url.path');

    $expectedVars['#cache']['contexts'][] = 'url.path';
    $this->assertSame($expectedVars, $vars);
  }

}
