<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess;

use Drupal\hook_event_dispatcher\Event\Preprocess\CommentPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\EckEntityPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\NodePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ParagraphPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\TaxonomyTermPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables;
use Drupal\hook_event_dispatcher\Service\PreprocessEventService;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\EntityMock;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\SpyEventDispatcher;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\YamlDefinitionsLoader;
use Drupal\Tests\UnitTestCase;

/**
 * Class EntityEventTest.
 *
 * @group hook_event_dispatcher
 */
final class EntityEventTest extends UnitTestCase {

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
  public function testCommentEvent() {
    $this->variables = [
      'comment' => new EntityMock('comment', 'bundle', 'view_mode'),
      'view_mode' => 'view_mode',
    ];
    $this->createAndAssertEntityEvent(CommentPreprocessEvent::class);
  }

  /**
   * Test a EckEntityPreprocessEvent.
   */
  public function testEckEntityEvent() {
    $this->variables = [
      'elements' => [
        '#view_mode' => 'view_mode',
      ],
      'eck_entity' => new EntityMock('eck_entity', 'bundle', 'view_mode'),
      'theme_hook_original' => 'eck_entity',
      'bundle' => 'bundle',
    ];
    $this->createAndAssertEntityEvent(EckEntityPreprocessEvent::class);
  }

  /**
   * Test a NodePreprocessEvent.
   */
  public function testNodeEvent() {
    $this->variables = [
      'node' => new EntityMock('node', 'bundle', 'view_mode'),
      'theme_hook_original' => 'node',
      'view_mode' => 'view_mode',
    ];
    $this->createAndAssertEntityEvent(NodePreprocessEvent::class);
  }

  /**
   * Test a ParagraphPreprocessEvent.
   */
  public function testParagraphEvent() {
    $this->variables = [
      'paragraph' => new EntityMock('paragraph', 'bundle', 'view_mode'),
      'theme_hook_original' => 'paragraph',
      'view_mode' => 'view_mode',
    ];
    $this->createAndAssertEntityEvent(ParagraphPreprocessEvent::class);
  }

  /**
   * Test a TaxonomyTermPreprocessEvent.
   */
  public function testTaxonomyTermEvent() {
    $this->variables = [
      'term' => new EntityMock('taxonomy_term', 'bundle', 'view_mode'),
      'theme_hook_original' => 'taxonomy_term',
      'view_mode' => 'view_mode',
    ];
    $this->createAndAssertEntityEvent(TaxonomyTermPreprocessEvent::class);
  }

  /**
   * Create and assert the given entity event class.
   *
   * @param string $class
   *   Event class name.
   */
  private function createAndAssertEntityEvent($class) {
    $this->dispatcher->setExpectedEventCount(3);
    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\AbstractPreprocessEntityEvent $class */
    $this->service->createAndDispatchKnownEvents($class::getHook(), $this->variables);
    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\AbstractPreprocessEntityEvent[] $events */
    $events = $this->dispatcher->getEvents();

    $expectedName = $class::DISPATCH_NAME_PREFIX . $class::getHook();
    $firstEvent = \reset($events);
    $firstName = \key($events);
    $this->assertSame($expectedName, $firstName);
    $this->assertInstanceOf($class, $firstEvent);
    $this->assertInstanceOf(AbstractEventVariables::class, $firstEvent->getVariables());

    $secondEvent = \next($events);
    $secondName = \key($events);
    $bundle = $secondEvent->getVariables()->getEntityBundle();
    $this->assertNotNull($bundle);
    $this->assertInternalType('string', $bundle);
    $expectedName .= '.' . $bundle;
    $this->assertSame($expectedName, $secondName);
    $this->assertInstanceOf($class, $secondEvent);
    $this->assertInstanceOf(AbstractEventVariables::class, $secondEvent->getVariables());

    $thirdEvent = \next($events);
    $thirdName = \key($events);
    $viewMode = $thirdEvent->getVariables()->getViewMode();
    $this->assertNotNull($viewMode);
    $this->assertInternalType('string', $viewMode);
    $expectedName .= '.' . $viewMode;
    $this->assertSame($expectedName, $thirdName);
    $this->assertInstanceOf($class, $thirdEvent);
    $this->assertInstanceOf(AbstractEventVariables::class, $thirdEvent->getVariables());
  }

}
