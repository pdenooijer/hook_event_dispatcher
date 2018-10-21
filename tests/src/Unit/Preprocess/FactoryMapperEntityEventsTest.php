<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess;

use Drupal\hook_event_dispatcher\Event\Preprocess\AbstractPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\BlockPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\CommentPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\EckEntityPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ImagePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\NodePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ParagraphPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\TaxonomyTermPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\BlockEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\CommentEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\EckEntityEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ImageEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\NodeEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ParagraphEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\TaxonomyTermEventVariables;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\YamlDefinitionsLoader;
use Drupal\Tests\UnitTestCase;

/**
 * Class PreprocessEntityEventsTest.
 *
 * @group hook_event_dispatcher
 *
 * Testing all events gives expected PHPMD warnings.
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class FactoryMapperEntityEventsTest extends UnitTestCase {

  /**
   * Factory mapper.
   *
   * @var \Drupal\hook_event_dispatcher\Service\PreprocessEventFactoryMapper
   */
  private $mapper;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->mapper = YamlDefinitionsLoader::getInstance()->getMapper();
  }

  /**
   * Test a BlockPreprocessEvent.
   */
  public function testBlockEvent() {
    $variablesArray = $this->createVariablesArray();
    $variablesArray['elements']['#id'] = 22;
    $variablesArray['content']['test'] = ['success2'];

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\BlockEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(BlockPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(BlockEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    $this->assertEquals(22, $variables->getId());
    $this->assertEquals(['success2'], $variables->getContentChild('test'));
    $this->assertEquals([], $variables->getContentChild('none-existing'));
  }

  /**
   * Test a CommentPreprocessEvent.
   */
  public function testCommentEvent() {
    $variablesArray = $this->createVariablesArray();
    $variablesArray['comment'] = new \stdClass();

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\CommentEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(CommentPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(CommentEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    $this->assertInstanceOf(\stdClass::class, $variables->getComment());
  }

  /**
   * Test a EckEntityPreprocessEvent.
   */
  public function testEckEntityEvent() {
    $variablesArray = $this->createVariablesArray();
    $variablesArray['entity']['#entity'] = new \stdClass();
    $variablesArray['entity']['#entity_type'] = 'test_type';

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\EckEntityEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(EckEntityPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(EckEntityEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    $this->assertInstanceOf(\stdClass::class, $variables->getEntity());
    $this->assertEquals('test_type', $variables->getEntityType());
  }

  /**
   * Test a ImagePreprocessEvent.
   */
  public function testImageEvent() {
    $variablesArray = $this->createVariablesArray();

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ImageEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(ImagePreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(ImageEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
  }

  /**
   * Test a NodePreprocessEvent.
   */
  public function testNodeEvent() {
    $variablesArray = $this->createVariablesArray();
    $variablesArray['node'] = new \stdClass();

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\NodeEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(NodePreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(NodeEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    $this->assertInstanceOf(\stdClass::class, $variables->getNode());
  }

  /**
   * Test a ParagraphPreprocessEvent.
   */
  public function testParagraphEvent() {
    $variablesArray = $this->createVariablesArray();
    $variablesArray['paragraph'] = 'paragraph';

    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ParagraphEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(ParagraphPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(ParagraphEventVariables::class, $variables);

    $this->assertAbstractEventVariables($variables);
    $this->assertEquals('paragraph', $variables->getParagraph());
  }

  /**
   * Test a TaxonomyTermPreprocessEvent.
   */
  public function testTaxonomyTermEvent() {
    $variablesArray = $this->createVariablesArray();

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\TaxonomyTermEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(TaxonomyTermPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(TaxonomyTermEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
  }

  /**
   * Test the default event variable functions.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables $variables
   *   Variables object.
   */
  private function assertAbstractEventVariables(AbstractEventVariables $variables) {
    $this->assertEquals('success', $variables->get('test'));
    $this->assertEquals('default', $variables->get('test2', 'default'));

    $reference = &$variables->getByReference('reference');
    $this->assertEquals('first', $reference);
    $reference = 'second';
    $this->assertEquals('second', $variables->get('reference'));

    $variables->set('test3', 'new set');
    $this->assertEquals('new set', $variables->get('test3'));

    $variables->remove('test');
    $this->assertNull($variables->get('test'));
  }

  /**
   * Get the variables from the created event.
   *
   * @param string $class
   *   Event class name.
   * @param array $variablesArray
   *   Variables array.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables
   *   Variables object.
   */
  private function getVariablesFromCreatedEvent($class, array $variablesArray) {
    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\PreprocessEventInterface $class */
    $hook = $class::getHook();
    $this->assertEquals(AbstractPreprocessEvent::DISPATCH_NAME_PREFIX . $hook, $class::name());

    $factory = $this->mapper->getFactory($hook);
    $this->assertEquals($hook, $factory->getEventHook());

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\PreprocessEventInterface $event*/
    $event = $factory->createEvent($variablesArray);
    $this->assertInstanceOf($class, $event);

    return $event->getVariables();
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

}
