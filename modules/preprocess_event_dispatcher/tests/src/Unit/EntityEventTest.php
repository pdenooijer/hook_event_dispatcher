<?php

namespace Drupal\Tests\preprocess_event_dispatcher\Unit;

use Drupal\comment\CommentInterface;
use Drupal\eck\EckEntityInterface;
use Drupal\node\NodeInterface;
use Drupal\paragraphs\ParagraphInterface;
use Drupal\preprocess_event_dispatcher\Event\CommentPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\EckEntityPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\NodePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\ParagraphPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\TaxonomyTermPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Service\PreprocessEventService;
use Drupal\taxonomy\TermInterface;
use Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers\EntityMockFactory;
use Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers\SpyEventDispatcher;
use Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers\YamlDefinitionsLoader;
use PHPUnit\Framework\TestCase;
use function key;
use function next;
use function reset;

/**
 * Class EntityEventTest.
 *
 * @group preprocess_event_dispatcher
 *
 * Testing all lots of classes gives expected coupling warnings.
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class EntityEventTest extends TestCase {

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
   * {@inheritdoc}
   */
  public function setUp(): void {
    $loader = YamlDefinitionsLoader::getInstance();
    $this->dispatcher = new SpyEventDispatcher();
    $this->service = new PreprocessEventService($this->dispatcher, $loader->getMapper());
  }

  /**
   * Test a BlockPreprocessEvent.
   */
  public function testCommentEvent(): void {
    $variables = [
      'comment' => EntityMockFactory::getMock(CommentInterface::class, 'comment', 'bundle', 'view_mode'),
      'view_mode' => 'view_mode',
    ];
    $this->createAndAssertEntityEvent(CommentPreprocessEvent::class, $variables);
  }

  /**
   * Test a EckEntityPreprocessEvent.
   */
  public function testEckEntityEvent(): void {
    $variables = [
      'elements' => [
        '#view_mode' => 'view_mode',
      ],
      'eck_entity' => EntityMockFactory::getMock(EckEntityInterface::class, 'eck_entity', 'bundle', 'view_mode'),
      'theme_hook_original' => 'eck_entity',
      'bundle' => 'bundle',
    ];
    $this->createAndAssertEntityEvent(EckEntityPreprocessEvent::class, $variables);
  }

  /**
   * Test a NodePreprocessEvent.
   */
  public function testNodeEvent(): void {
    $variables = [
      'node' => EntityMockFactory::getMock(NodeInterface::class, 'node', 'bundle', 'view_mode'),
      'theme_hook_original' => 'node',
      'view_mode' => 'view_mode',
    ];
    $this->createAndAssertEntityEvent(NodePreprocessEvent::class, $variables);
  }

  /**
   * Test a ParagraphPreprocessEvent.
   */
  public function testParagraphEvent(): void {
    $variables = [
      'paragraph' => EntityMockFactory::getMock(ParagraphInterface::class, 'paragraph', 'bundle', 'view_mode'),
      'theme_hook_original' => 'paragraph',
      'view_mode' => 'view_mode',
    ];
    $this->createAndAssertEntityEvent(ParagraphPreprocessEvent::class, $variables);
  }

  /**
   * Test a TaxonomyTermPreprocessEvent.
   */
  public function testTaxonomyTermEvent(): void {
    $variables = [
      'term' => EntityMockFactory::getMock(TermInterface::class, 'taxonomy_term', 'bundle', 'view_mode'),
      'theme_hook_original' => 'taxonomy_term',
      'view_mode' => 'view_mode',
    ];
    $this->createAndAssertEntityEvent(TaxonomyTermPreprocessEvent::class, $variables);
  }

  /**
   * Create and assert the given entity event class.
   *
   * @param string $class
   *   Event class name.
   * @param array $variables
   *   Variables.
   */
  private function createAndAssertEntityEvent(string $class, array $variables): void {
    $this->dispatcher->setExpectedEventCount(3);
    /** @var \Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEntityEvent $class */
    $this->service->createAndDispatchKnownEvents($class::getHook(), $variables);
    /** @var \Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEntityEvent[] $events */
    $events = $this->dispatcher->getEvents();

    $expectedName = $class::DISPATCH_NAME_PREFIX . $class::getHook();
    $firstEvent = reset($events);
    $firstName = key($events);
    self::assertSame($expectedName, $firstName);
    self::assertInstanceOf($class, $firstEvent);
    self::assertNotNull($firstEvent->getVariables());

    $secondEvent = next($events);
    $secondName = key($events);
    /** @var \Drupal\preprocess_event_dispatcher\Variables\AbstractEntityEventVariables $secondVariables */
    $secondVariables = $secondEvent->getVariables();
    $bundle = $secondVariables->getEntityBundle();
    $expectedName .= '.' . $bundle;
    self::assertSame($expectedName, $secondName);
    self::assertInstanceOf($class, $secondEvent);

    $thirdEvent = next($events);
    $thirdName = key($events);
    /** @var \Drupal\preprocess_event_dispatcher\Variables\AbstractEntityEventVariables $thirdVariables */
    $thirdVariables = $thirdEvent->getVariables();
    $viewMode = $thirdVariables->getViewMode();
    $expectedName .= '.' . $viewMode;
    self::assertSame($expectedName, $thirdName);
    self::assertInstanceOf($class, $thirdEvent);
  }

}
