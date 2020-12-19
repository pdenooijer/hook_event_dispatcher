<?php

namespace Drupal\Tests\preprocess_event_dispatcher\Unit;

use Drupal\preprocess_event_dispatcher\Event\BlockPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\FieldPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\FormPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\HtmlPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\ImagePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\PagePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\StatusMessagesPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\ViewFieldPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\ViewPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Service\PreprocessEventService;
use Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers\SpyEventDispatcher;
use Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers\YamlDefinitionsLoader;
use PHPUnit\Framework\TestCase;
use function str_replace;

/**
 * Class OtherEventTest.
 *
 * @group preprocess_event_dispatcher
 *
 * Testing all variables gives expected PHPMD warnings.
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class OtherEventTest extends TestCase {

  /**
   * PreprocessEventService.
   *
   * @var \Drupal\preprocess_event_dispatcher\Service\PreprocessEventService
   *   PreprocessEventService.
   */
  private $service;

  /**
   * SpyEventDispatcher.
   *
   * @var \Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers\SpyEventDispatcher
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
  public function setUp(): void {
    $loader = YamlDefinitionsLoader::getInstance();
    $this->dispatcher = new SpyEventDispatcher();
    $this->service = new PreprocessEventService($this->dispatcher, $loader->getMapper());
    $this->variables = [];
  }

  /**
   * Test a BlockPreprocessEvent.
   */
  public function testBlockEvent(): void {
    $this->createAndAssertEvent(BlockPreprocessEvent::class);
  }

  /**
   * Test a FieldPreprocessEvent.
   */
  public function testFieldEvent(): void {
    $this->createAndAssertEvent(FieldPreprocessEvent::class);
  }

  /**
   * Test a FormPreprocessEvent.
   */
  public function testFormEvent(): void {
    $this->createAndAssertEvent(FormPreprocessEvent::class);
  }

  /**
   * Test a HtmlPreprocessEvent.
   */
  public function testHtmlEvent(): void {
    $this->createAndAssertEvent(HtmlPreprocessEvent::class);
  }

  /**
   * Test a ImagePreprocessEvent.
   */
  public function testImageEvent(): void {
    $this->createAndAssertEvent(ImagePreprocessEvent::class);
  }

  /**
   * Test a PagePreprocessEvent.
   */
  public function testPageEvent(): void {
    $this->createAndAssertEvent(PagePreprocessEvent::class);
  }

  /**
   * Test a ViewFieldPreprocessEvent.
   */
  public function testViewFieldEvent(): void {
    $this->createAndAssertEvent(ViewFieldPreprocessEvent::class);
  }

  /**
   * Test a ViewPreprocessEvent.
   */
  public function testViewEvent(): void {
    $this->createAndAssertEvent(ViewPreprocessEvent::class);
  }

  /**
   * Test a StatusMessagesPreprocessEvent.
   */
  public function testStatusMessagesEvent(): void {
    $this->createAndAssertEvent(StatusMessagesPreprocessEvent::class);
  }

  /**
   * Test a unknown hook.
   */
  public function testNotMappingEvent(): void {
    $this->service->createAndDispatchKnownEvents('NoneExistingHook', $this->variables);
    self::assertSame([], $this->dispatcher->getEvents());
  }

  /**
   * Create and assert the given event class.
   *
   * @param string $class
   *   Event class name.
   */
  private function createAndAssertEvent(string $class): void {
    /** @var \Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent $class */
    $this->service->createAndDispatchKnownEvents($class::getHook(), $this->variables);
    self::assertSame($class::name(), $this->dispatcher->getLastEventName());
    /** @var \Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent $event */
    $event = $this->dispatcher->getLastEvent();
    self::assertInstanceOf($class, $event);
    $variablesClass = str_replace(
      ['\\Event\\', 'PreprocessEvent'],
      ['\\Variables\\', 'EventVariables'],
      $class
    );
    self::assertInstanceOf($variablesClass, $event->getVariables());
  }

}
