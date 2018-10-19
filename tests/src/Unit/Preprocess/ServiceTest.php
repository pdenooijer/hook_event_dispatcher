<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess;

use Drupal\hook_event_dispatcher\Event\Preprocess\BlockPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\CommentPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\EckEntityPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ContentEntityPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ContentEntityBundlePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\FieldPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\FormPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\HtmlPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ImagePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\NodePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\PagePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ParagraphPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\TaxonomyTermPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ContentEntityEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\ViewFieldPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ViewPreprocessEvent;
use Drupal\hook_event_dispatcher\Service\PreprocessEventService;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\YamlDefinitionsLoader;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\SpyEventDispatcher;
use Drupal\Tests\UnitTestCase;
use Drupal\Core\Entity\ContentEntityInterface;

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
    $this->createAndAssertEvent(BlockPreprocessEvent::class, BlockPreprocessEvent::getHook(), [], BlockPreprocessEvent::name());
  }

  /**
   * Test a BlockPreprocessEvent.
   */
  public function testCommentEvent() {
    $this->createAndAssertEvent(CommentPreprocessEvent::class, CommentPreprocessEvent::getHook(), [], CommentPreprocessEvent::name());
  }

  /**
   * Test a EckEntityPreprocessEvent.
   */
  public function testEckEntityEvent() {
    $hook = EckEntityPreprocessEvent::getHook();
    $entityBundle = 'test_bundle';
    $entityViewMode = 'test_view';

    $entity = $this->getMockForAbstractClass(ContentEntityInterface::class);
    $entity
      ->expects($this->any())
      ->method('bundle')
      ->willReturn($entityBundle);

    $variablesArray = $this->createVariablesArray();
    $variablesArray['elements']['#entity_type'] = $hook;
    $variablesArray['view_mode'] = $entityViewMode;
    $variablesArray[$hook] = $entity;

    $this->createAndAssertEvent(EckEntityPreprocessEvent::class, $hook, $variablesArray, EckEntityPreprocessEvent::name(), 2);
  }

  /**
   * Test a EntityPreprocessEvent.
   */
  public function testEntityTypeEvent() {
    $hook = 'test_type';
    $entityBundle = 'test_bundle';
    $entityViewMode = 'test_view';

    $entity = $this->getMockForAbstractClass(ContentEntityInterface::class);
    $entity
      ->expects($this->any())
      ->method('bundle')
      ->willReturn($entityBundle);

    $variablesArray = $this->createVariablesArray();
    $variablesArray['elements']['#entity_type'] = $hook;
    $variablesArray['view_mode'] = $entityViewMode;
    $variablesArray[$hook] = $entity;

    $eventName = ContentEntityPreprocessEvent::name() . '.' . $hook;
    $this->createAndAssertEvent(ContentEntityPreprocessEvent::class, $hook, $variablesArray, $eventName, 2);
  }

  /**
   * Test a EntityPreprocessEvent.
   */
  public function testEntityBundleEvent() {
    $hook = 'test_type';
    $entityBundle = 'test_bundle';
    $entityViewMode = 'test_view';

    $entity = $this->getMockForAbstractClass(ContentEntityInterface::class);
    $entity
      ->expects($this->any())
      ->method('bundle')
      ->willReturn($entityBundle);

    $variablesArray = $this->createVariablesArray();
    $variablesArray['elements']['#entity_type'] = $hook;
    $variablesArray['view_mode'] = $entityViewMode;
    $variablesArray[$hook] = $entity;

    $eventName = ContentEntityBundlePreprocessEvent::name() . '.' . $hook . '.' . $entityBundle;
    $this->createAndAssertEvent(ContentEntityBundlePreprocessEvent::class, $hook, $variablesArray, $eventName, 2);
  }

  /**
   * Test a FieldPreprocessEvent.
   */
  public function testFieldEvent() {
    $this->createAndAssertEvent(FieldPreprocessEvent::class, FieldPreprocessEvent::getHook(), [], FieldPreprocessEvent::name());
  }

  /**
   * Test a FormPreprocessEvent.
   */
  public function testFormEvent() {
    $this->createAndAssertEvent(FormPreprocessEvent::class, FormPreprocessEvent::getHook(), [], FormPreprocessEvent::name());
  }

  /**
   * Test a HtmlPreprocessEvent.
   */
  public function testHtmlEvent() {
    $this->createAndAssertEvent(HtmlPreprocessEvent::class, HtmlPreprocessEvent::getHook(), [], HtmlPreprocessEvent::name());
  }

  /**
   * Test a ImagePreprocessEvent.
   */
  public function testImageEvent() {
    $this->createAndAssertEvent(ImagePreprocessEvent::class, ImagePreprocessEvent::getHook(), [], ImagePreprocessEvent::name());
  }

  /**
   * Test a NodePreprocessEvent.
   */
  public function testNodeEvent() {
    $hook = NodePreprocessEvent::getHook();
    $entityBundle = 'test_bundle';
    $entityViewMode = 'test_view';

    $entity = $this->getMockForAbstractClass(ContentEntityInterface::class);
    $entity
      ->expects($this->any())
      ->method('bundle')
      ->willReturn($entityBundle);

    $variablesArray = $this->createVariablesArray();
    $variablesArray['elements']['#entity_type'] = $hook;
    $variablesArray['view_mode'] = $entityViewMode;
    $variablesArray[$hook] = $entity;

    $this->createAndAssertEvent(NodePreprocessEvent::class, $hook, $variablesArray, NodePreprocessEvent::name(), 2);
  }

  /**
   * Test a PagePreprocessEvent.
   */
  public function testPageEvent() {
    $this->createAndAssertEvent(PagePreprocessEvent::class, PagePreprocessEvent::getHook(), [], PagePreprocessEvent::name());
  }

  /**
   * Test a TaxonomyTermPreprocessEvent.
   */
  public function testTaxonomyTermEvent() {
    $hook = TaxonomyTermPreprocessEvent::getHook();
    $entityBundle = 'test_bundle';
    $entityViewMode = 'test_view';

    $entity = $this->getMockForAbstractClass(ContentEntityInterface::class);
    $entity
      ->expects($this->any())
      ->method('bundle')
      ->willReturn($entityBundle);

    $variablesArray = $this->createVariablesArray();
    $variablesArray['elements']['#entity_type'] = $hook;
    $variablesArray['view_mode'] = $entityViewMode;
    $variablesArray[$hook] = $entity;

    $this->createAndAssertEvent(TaxonomyTermPreprocessEvent::class, $hook, $variablesArray, TaxonomyTermPreprocessEvent::name(), 2);
  }

  /**
   * Test a ViewFieldPreprocessEvent.
   */
  public function testViewFieldEvent() {
    $this->createAndAssertEvent(ViewFieldPreprocessEvent::class, ViewFieldPreprocessEvent::getHook(), [], ViewFieldPreprocessEvent::name());
  }

  /**
   * Test a ParagraphPreprocessEvent.
   */
  public function testParagraphEvent() {
    $hook = ParagraphPreprocessEvent::getHook();
    $entityBundle = 'test_bundle';
    $entityViewMode = 'test_view';

    $entity = $this->getMockForAbstractClass(ContentEntityInterface::class);
    $entity
      ->expects($this->any())
      ->method('bundle')
      ->willReturn($entityBundle);

    $variablesArray = $this->createVariablesArray();
    $variablesArray['elements']['#entity_type'] = $hook;
    $variablesArray['view_mode'] = $entityViewMode;
    $variablesArray[$hook] = $entity;

    $this->createAndAssertEvent(ParagraphPreprocessEvent::class, $hook, $variablesArray, ParagraphPreprocessEvent::name(), 2);
  }

  /**
   * Test a ViewPreprocessEvent.
   */
  public function testViewEvent() {
    $this->createAndAssertEvent(ViewPreprocessEvent::class, ViewPreprocessEvent::getHook(), [], ViewPreprocessEvent::name());
  }

  /**
   * Test a unknown hook.
   */
  public function testNotMappingEvent() {
    $this->service->createAndDispatchKnownEvents('NoneExistingHook', $this->variables);
    $this->assertEquals([], $this->dispatcher->getEventNames());
    $this->assertEquals([], $this->dispatcher->getEvents());
  }

  /**
   * Create and assert the given event class.
   *
   * @param string $class
   *   The event class.
   * @param string $hook
   *   The hook.
   * @param array $variables
   *   The variables.
   * @param string $eventName
   *   The event name.
   * @param int $eventsToFire
   *   The number of events to fire for this hook.
   */
  private function createAndAssertEvent($class, $hook, array $variables, $eventName, $eventsToFire = 1) {
    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\AbstractPreprocessEvent $class */
    $this->service->createAndDispatchKnownEvents($hook, $variables);
    $this->assertContains($eventName, $this->dispatcher->getEventNames());
    $this->assertEquals($eventsToFire, count($this->dispatcher->getEventNames()));
    $this->assertArrayHasObjectOfType($class, $this->dispatcher->getEvents());
  }

  /**
   * Create the variables array.
   *
   * @return array
   *   Variables array.
   */
  private function createVariablesArray() {
    return [
      'test' => 'success',
      'reference' => 'first',
    ];
  }

  /**
   * Assert that array has an object of type.
   */
  private function assertArrayHasObjectOfType($type, $array, $message = '') {
    $found = FALSE;
    foreach ($array as $obj) {
      if (get_class($obj) === $type) {
        $found = TRUE;
        break;
      }
    }
    $this->assertTrue($found, $message);
  }

}
