<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess;

use Drupal\hook_event_dispatcher\Event\Preprocess\BlockPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\CommentPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\EckEntityPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\FieldPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\FormPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\HtmlPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ImagePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\NodePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\PagePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ParagraphPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\TaxonomyTermPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ViewFieldPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ViewPreprocessEvent;
use Drupal\hook_event_dispatcher\Service\PreprocessEventService;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\YamlDefinitionsLoader;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\SpyEventDispatcher;
use Drupal\Tests\UnitTestCase;

/**
 * Class ServiceTest.
 *
 * @group hook_event_dispatcher
 *
 * Testing all events gives expected PHPMD warnings.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class ServiceTest extends UnitTestCase {

  /**
   * PreprocessEventService.
   *
   * @var \Drupal\hook_event_dispatcher\Service\PreprocessEventService
   *   PreprocessEventService.
   */
  private $service;

  /**
   * SpyEventDispatcher.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\SpyEventDispatcher
   *   SpyEventDispatcher
   */
  private $dispatcher;

  /**
   * Variables array.
   *
   * @var array
   *   Variables.
   */
  private $variables = [];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $loader = YamlDefinitionsLoader::getInstance();
    $this->dispatcher = new SpyEventDispatcher();
    $this->service = new PreprocessEventService($this->dispatcher, $loader->getMapper());
  }

  /**
   * Test a BlockPreprocessEvent.
   */
  public function testBlockEvent() {
    $this->createAndAssertEvent(BlockPreprocessEvent::class);
  }

  /**
   * Test a BlockPreprocessEvent.
   */
  public function testCommentEvent() {
    $this->createAndAssertEvent(CommentPreprocessEvent::class);
  }

  /**
   * Test a EckEntityPreprocessEvent.
   */
  public function testEckEntityEvent() {
    $this->createAndAssertEvent(EckEntityPreprocessEvent::class);
  }

  /**
   * Test a FieldPreprocessEvent.
   */
  public function testFieldEvent() {
    $this->createAndAssertEvent(FieldPreprocessEvent::class);
  }

  /**
   * Test a FormPreprocessEvent.
   */
  public function testFormEvent() {
    $this->createAndAssertEvent(FormPreprocessEvent::class);
  }

  /**
   * Test a HtmlPreprocessEvent.
   */
  public function testHtmlEvent() {
    $this->createAndAssertEvent(HtmlPreprocessEvent::class);
  }

  /**
   * Test a ImagePreprocessEvent.
   */
  public function testImageEvent() {
    $this->createAndAssertEvent(ImagePreprocessEvent::class);
  }

  /**
   * Test a NodePreprocessEvent.
   */
  public function testNodeEvent() {
    $this->createAndAssertEvent(NodePreprocessEvent::class);
  }

  /**
   * Test a PagePreprocessEvent.
   */
  public function testPageEvent() {
    $this->createAndAssertEvent(PagePreprocessEvent::class);
  }

  /**
   * Test a PagePreprocessEvent.
   */
  public function testTaxonomyTermEvent() {
    $this->createAndAssertEvent(TaxonomyTermPreprocessEvent::class);
  }

  /**
   * Test a ViewFieldPreprocessEvent.
   */
  public function testViewFieldEvent() {
    $this->createAndAssertEvent(ViewFieldPreprocessEvent::class);
  }

  /**
   * Test a ParagraphPreprocessEvent.
   */
  public function testParagraphEvent() {
    $this->createAndAssertEvent(ParagraphPreprocessEvent::class);
  }

  /**
   * Test a ViewPreprocessEvent.
   */
  public function testViewEvent() {
    $this->createAndAssertEvent(ViewPreprocessEvent::class);
  }

  /**
   * Test a unknown hook.
   */
  public function testNotMappingEvent() {
    $this->service->createAndDispatchKnownEvent('NoneExistingHook', $this->variables);
    $this->assertEquals(NULL, $this->dispatcher->getLastEventName());
    $this->assertEquals(NULL, $this->dispatcher->getLastEvent());
  }

  /**
   * Create and assert the given event class.
   *
   * @param string $class
   *   Event class name.
   */
  private function createAndAssertEvent($class) {
    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\AbstractPreprocessEvent $class */
    $this->service->createAndDispatchKnownEvent($class::getHook(), $this->variables);
    $this->assertEquals($class::name(), $this->dispatcher->getLastEventName());
    $this->assertInstanceOf($class, $this->dispatcher->getLastEvent());
  }

}
