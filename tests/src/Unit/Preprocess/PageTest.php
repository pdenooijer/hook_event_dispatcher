<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess;

use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\PageEventVariables;
use Drupal\node\NodeInterface;
use Drupal\Tests\UnitTestCase;
use stdClass;

/**
 * Class PageTest.
 *
 * @group hook_event_dispatcher
 */
final class PageTest extends UnitTestCase {
  /**
   * Mock node object.
   *
   * @var \Drupal\node\Entity\Node
   */
  protected $node;

  /**
   * Setup.
   */
  public function setUp() {
    $this->node = $this->getMockBuilder(NodeInterface::class)
      ->disableOriginalClone()
      ->disableOriginalConstructor()
      ->getMock();
  }

  /**
   * Test the getter.
   */
  public function testGet() {
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
  public function testSet() {
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
  public function testVarByRef() {
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
  public function testIsNodePage() {
    $vars = [];
    $page = new PageEventVariables($vars);
    self::assertFalse($page->isNodePage());
    $vars['node'] = new stdClass();
    self::assertFalse($page->isNodePage());
    $vars['node'] = $this->node;
    self::assertTrue($page->isNodePage());
  }

  /**
   * Test getNode() call.
   */
  public function testGetNode() {
    $vars = [];
    $page = new PageEventVariables($vars);
    self::assertEquals(NULL, $page->getNode());
    $page->set('node', new stdClass());
    self::assertEquals(NULL, $page->getNode());
    $vars['node'] = $this->node;
    self::assertInstanceOf(NodeInterface::class, $page->getNode());
  }

  /**
   * Test getting a var by ref and changing it.
   */
  public function testGetVarByRef() {
    $vars = [];
    $vars['page']['test'] = 'test';
    $page = new PageEventVariables($vars);
    $test = &$page->getByReference('test');
    self::assertEquals('test', $test);
    $test = 'OtherTest';
    self::assertEquals('OtherTest', $page->get('test'));
    self::assertEquals('OtherTest', $vars['page']['test']);
  }

  /**
   * Test getting root variables by reference.
   */
  public function testGetRootVariablesByReference() {
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
  public function testAddCacheContext() {
    $vars = $expectedVars = [];
    $page = new PageEventVariables($vars);
    $page->addCacheContext('url.path');

    $expectedVars['#cache']['contexts'][] = 'url.path';
    self::assertSame($expectedVars, $vars);
  }

}
