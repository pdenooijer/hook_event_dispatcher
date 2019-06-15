<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess;

use Drupal\hook_event_dispatcher\Event\Preprocess\AbstractPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\CommentPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\EckEntityPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\NodePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ParagraphPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\PreprocessEntityEventInterface;
use Drupal\hook_event_dispatcher\Event\Preprocess\TaxonomyTermPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEntityEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\CommentEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\EckEntityEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\NodeEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ParagraphEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\TaxonomyTermEventVariables;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\EntityMock;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\YamlDefinitionsLoader;
use Drupal\Tests\UnitTestCase;

/**
 * Class EntityEventVariablesTest.
 *
 * @group hook_event_dispatcher
 *
 * Testing all variables gives expected PHPMD warnings.
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class EntityEventVariablesTest extends UnitTestCase {

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
   * Test a CommentPreprocessEvent.
   */
  public function testCommentEvent() {
    $comment = new EntityMock('comment', 'comment_bundle', 'comment_view_mode');
    $variablesArray = $this->createVariablesArray();
    $variablesArray['comment'] = $comment;
    $variablesArray['commented_entity'] = 'node';
    $variablesArray['view_mode'] = $comment->getViewMode();

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\CommentEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(CommentPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(CommentEventVariables::class, $variables);
    $this->assertAbstractEntityEventVariables($variables, $comment);
    $this->assertSame($comment, $variables->getComment());
    $this->assertSame('node', $variables->getCommentedEntity());
  }

  /**
   * Test a EckEntityPreprocessEvent.
   */
  public function testEckEntityEvent() {
    $eckEntity = new EntityMock('eck_entity', 'eck_entity_bundle', 'eck_entity_view_mode');
    $variablesArray = $this->createVariablesArray();

    $variablesArray['eck_entity'] = $eckEntity;
    $variablesArray['elements'] = [
      '#view_mode' => $eckEntity->getViewMode(),
    ];
    $variablesArray['theme_hook_original'] = $eckEntity->getEntityType();
    $variablesArray['bundle'] = $eckEntity->bundle();

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\EckEntityEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(EckEntityPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(EckEntityEventVariables::class, $variables);
    $this->assertAbstractEntityEventVariables($variables, $eckEntity);
    $this->assertSame($eckEntity, $variables->getEckEntity());
  }

  /**
   * Test a NodePreprocessEvent.
   */
  public function testNodeEvent() {
    $node = new EntityMock('node', 'node_bundle', 'node_view_mode');
    $variablesArray = $this->createVariablesArray();
    $variablesArray['node'] = $node;
    $variablesArray['theme_hook_original'] = $node->getEntityType();
    $variablesArray['view_mode'] = $node->getViewMode();

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\NodeEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(NodePreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(NodeEventVariables::class, $variables);
    $this->assertAbstractEntityEventVariables($variables, $node);
    $this->assertSame($node, $variables->getNode());
  }

  /**
   * Test a ParagraphPreprocessEvent.
   */
  public function testParagraphEvent() {
    $paragraph = new EntityMock('paragraph', 'paragraph_bundle', 'paragraph_view_mode');
    $variablesArray = $this->createVariablesArray();
    $variablesArray['paragraph'] = $paragraph;
    $variablesArray['theme_hook_original'] = $paragraph->getEntityType();
    $variablesArray['view_mode'] = $paragraph->getViewMode();

    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ParagraphEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(ParagraphPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(ParagraphEventVariables::class, $variables);
    $this->assertAbstractEntityEventVariables($variables, $paragraph);
    $this->assertSame($paragraph, $variables->getParagraph());
  }

  /**
   * Test a TaxonomyTermPreprocessEvent.
   */
  public function testTaxonomyTermEvent() {
    $term = new EntityMock('taxonomy_term', 'term_bundle', 'term_view_mode');
    $variablesArray = $this->createVariablesArray();
    $variablesArray['term'] = $term;
    $variablesArray['theme_hook_original'] = $term->getEntityType();
    $variablesArray['view_mode'] = $term->getViewMode();

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\TaxonomyTermEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(TaxonomyTermPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(TaxonomyTermEventVariables::class, $variables);
    $this->assertAbstractEntityEventVariables($variables, $term);
    $this->assertSame($term, $variables->getTerm());
  }

  /**
   * Test the default entity event variable methods.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEntityEventVariables $variables
   *   Variables object.
   * @param \Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\EntityMock $entity
   *   Entity mock.
   */
  private function assertAbstractEntityEventVariables(AbstractEntityEventVariables $variables, EntityMock $entity) {
    $this->assertAbstractEventVariables($variables);

    $this->assertSame($entity, $variables->getEntity());
    $this->assertSame($entity->getEntityType(), $variables->getEntityType());
    $this->assertSame($entity->bundle(), $variables->getEntityBundle());
    $this->assertSame($entity->getViewMode(), $variables->getViewMode());
  }

  /**
   * Test the default event variable methods.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEntityEventVariables $variables
   *   Variables object.
   */
  private function assertAbstractEventVariables(AbstractEntityEventVariables $variables) {
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
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEntityEventVariables
   *   Variables object.
   */
  private function getVariablesFromCreatedEvent($class, array $variablesArray) {
    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\PreprocessEventInterface $class */
    $hook = $class::getHook();
    $this->assertEquals(AbstractPreprocessEvent::DISPATCH_NAME_PREFIX . $hook, $class::name());

    $factory = $this->mapper->getFactory($hook);
    $this->assertEquals($hook, $factory->getEventHook());

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\PreprocessEntityEventInterface $event*/
    $event = $factory->createEvent($variablesArray);
    $this->assertInstanceOf(PreprocessEntityEventInterface::class, $event);
    $this->assertInstanceOf($class, $event);

    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEntityEventVariables $variables */
    $variables = $event->getVariables();
    $this->assertInstanceOf(AbstractEntityEventVariables::class, $variables);
    return $variables;
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
