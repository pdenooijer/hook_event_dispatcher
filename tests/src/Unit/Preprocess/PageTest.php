<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess;

use Drupal\node\Entity\Node;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\PageEventVariables;

/**
 * Class PageTest.
 */
final class PageTest extends \PHPUnit_Framework_TestCase {
  /**
   * Mock node object.
   *
   * @var Node
   */
  protected $node;

  /**
   * Setup.
   */
  public function setUp() {
    parent::setUp();

    $this->node = $this->getMockBuilder(Node::class)
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
    $this->assertInstanceOf('\stdClass', $page->get('object'));
    $this->assertFalse($page->get('doesnotexists', FALSE));
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
    $this->assertInstanceOf('\stdClass', $page->get('object'));
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
    $this->assertInstanceOf('\stdClass', $page->get('object'));
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
    $this->assertInstanceOf(Node::class, $page->getNode());
  }

}
