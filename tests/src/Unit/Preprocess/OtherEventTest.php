<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess;

use Drupal\hook_event_dispatcher\Event\Preprocess\BlockPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\FieldPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\FormPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\HtmlPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ImagePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\PagePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\StatusMessagesPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\ViewFieldPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ViewPreprocessEvent;
use Drupal\hook_event_dispatcher\Service\PreprocessEventService;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\SpyEventDispatcher;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\YamlDefinitionsLoader;
use Drupal\Tests\UnitTestCase;

/**
 * Class OtherEventTest.
 *
 * @group hook_event_dispatcher
 *
 * Testing all variables gives expected PHPMD warnings.
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class OtherEventTest extends UnitTestCase {

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
  private $variables;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $loader = YamlDefinitionsLoader::getInstance();
    $this->dispatcher = new SpyEventDispatcher();
    $this->service = new PreprocessEventService($this->dispatcher, $loader->getMapper());
    $this->variables = [];
  }

  /**
   * Test a BlockPreprocessEvent.
   */
  public function testBlockEvent() {
    $this->createAndAssertEvent(BlockPreprocessEvent::class);
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
   * Test a PagePreprocessEvent.
   */
  public function testPageEvent() {
    $this->createAndAssertEvent(PagePreprocessEvent::class);
  }

  /**
   * Test a ViewFieldPreprocessEvent.
   */
  public function testViewFieldEvent() {
    $this->createAndAssertEvent(ViewFieldPreprocessEvent::class);
  }

  /**
   * Test a ViewPreprocessEvent.
   */
  public function testViewEvent() {
    $this->createAndAssertEvent(ViewPreprocessEvent::class);
  }

  /**
   * Test a StatusMessagesPreprocessEvent.
   */
  public function testStatusMessagesEvent() {
    $this->createAndAssertEvent(StatusMessagesPreprocessEvent::class);
  }

  /**
   * Test a unknown hook.
   */
  public function testNotMappingEvent() {
    $this->service->createAndDispatchKnownEvents('NoneExistingHook', $this->variables);
    $this->assertSame([], $this->dispatcher->getEvents());
  }

  /**
   * Create and assert the given event class.
   *
   * @param string $class
   *   Event class name.
   */
  private function createAndAssertEvent($class) {
    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\AbstractPreprocessEvent $class */
    $this->service->createAndDispatchKnownEvents($class::getHook(), $this->variables);
    $this->assertSame($class::name(), $this->dispatcher->getLastEventName());
    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\AbstractPreprocessEvent $event */
    $event = $this->dispatcher->getLastEvent();
    $this->assertInstanceOf($class, $event);
    $this->assertInstanceOf(AbstractEventVariables::class, $event->getVariables());
  }

}
