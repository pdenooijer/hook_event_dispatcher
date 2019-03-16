<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess;

use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\PageEventVariables;
use Drupal\node\NodeInterface;
use Drupal\Tests\UnitTestCase;

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
    $vars['page']['test'] = TRUE;
    $vars['page']['array'] = ['array key' => 1];
    $vars['page']['object'] = new \stdClass();
    $page = new PageEventVariables($vars);
    $this->assertTrue($page->get('test'));
    $this->assertArrayHasKey('array key', $page->get('array'));
    $this->assertInstanceOf(\stdClass::class, $page->get('object'));
    $this->assertFalse($page->get('doesNotExists', FALSE));
  }

  /**
   * Test the setter.
   */
  public function testSet() {
    $vars = [];
    $page = new PageEventVariables($vars);
    $page->set('test', TRUE);
    $page->set('array', ['array key' => 1]);
    $page->set('object', new \stdClass());
    $this->assertTrue($page->get('test'));
    $this->assertArrayHasKey('array key', $page->get('array'));
    $this->assertInstanceOf(\stdClass::class, $page->get('object'));
    $page->set('null');
    $this->assertNull($page->get('null'));
  }

  /**
   * The the vars by ref.
   */
  public function testVarByRef() {
    $vars = [];
    $page = new PageEventVariables($vars);
    $vars['page']['test'] = TRUE;
    $vars['page']['array'] = ['array key' => 1];
    $vars['page']['object'] = new \stdClass();
    $this->assertTrue($page->get('test'));
    $this->assertArrayHasKey('array key', $page->get('array'));
    $this->assertInstanceOf(\stdClass::class, $page->get('object'));
  }

  /**
   * Test is node page.
   */
  public function testIsNodePage() {
    $vars = [];
    $page = new PageEventVariables($vars);
    $this->assertFalse($page->isNodePage());
    $vars['node'] = new \stdClass();
    $this->assertFalse($page->isNodePage());
    $vars['node'] = $this->node;
    $this->assertTrue($page->isNodePage());
  }

  /**
   * Test getNode() call.
   */
  public function testGetNode() {
    $vars = [];
    $page = new PageEventVariables($vars);
    $this->assertEquals(NULL, $page->getNode());
    $page->set('node', new \stdClass());
    $this->assertEquals(NULL, $page->getNode());
    $vars['node'] = $this->node;
    $this->assertInstanceOf(NodeInterface::class, $page->getNode());
  }

  /**
   * Test getting a var by ref and changing it.
   */
  public function testGetVarByRef() {
    $vars['page']['test'] = 'test';
    $page = new PageEventVariables($vars);
    $test = &$page->getByReference('test');
    $this->assertEquals('test', $test);
    $test = 'OtherTest';
    $this->assertEquals('OtherTest', $page->get('test'));
    $this->assertEquals('OtherTest', $vars['page']['test']);
  }

  /**
   * Test getting root variables by reference.
   */
  public function testGetRootVariablesByReference() {
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
  public function testAddCacheContext() {
    $vars = [];
    $page = new PageEventVariables($vars);
    $page->addCacheContext('url.path');

    $expectedVars['#cache']['contexts'][] = 'url.path';
    $this->assertSame($expectedVars, $vars);
  }

}
