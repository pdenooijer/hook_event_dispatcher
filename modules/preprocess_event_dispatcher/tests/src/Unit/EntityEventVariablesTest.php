<?php

namespace Drupal\Tests\preprocess_event_dispatcher\Unit;

use Drupal\comment\CommentInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\eck\EckEntityInterface;
use Drupal\node\NodeInterface;
use Drupal\paragraphs\ParagraphInterface;
use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\CommentPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\EckEntityPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\NodePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\ParagraphPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\PreprocessEntityEventInterface;
use Drupal\preprocess_event_dispatcher\Event\TaxonomyTermPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\AbstractEntityEventVariables;
use Drupal\preprocess_event_dispatcher\Variables\CommentEventVariables;
use Drupal\preprocess_event_dispatcher\Variables\EckEntityEventVariables;
use Drupal\preprocess_event_dispatcher\Variables\NodeEventVariables;
use Drupal\preprocess_event_dispatcher\Variables\ParagraphEventVariables;
use Drupal\preprocess_event_dispatcher\Variables\TaxonomyTermEventVariables;
use Drupal\taxonomy\TermInterface;
use Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers\EntityMockFactory;
use Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers\YamlDefinitionsLoader;
use PHPUnit\Framework\TestCase;
use Mockery;

/**
 * Class EntityEventVariablesTest.
 *
 * @group preprocess_event_dispatcher
 *
 * Testing all variables gives expected PHPMD warnings.
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class EntityEventVariablesTest extends TestCase {

  /**
   * Factory mapper.
   *
   * @var \Drupal\preprocess_event_dispatcher\Service\PreprocessEventFactoryMapper
   */
  private $mapper;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    $this->mapper = YamlDefinitionsLoader::getInstance()->getMapper();
  }

  /**
   * Test a CommentPreprocessEvent.
   */
  public function testCommentEvent(): void {
    $comment = EntityMockFactory::getMock(CommentInterface::class, 'comment', 'comment_bundle', 'comment_view_mode');
    $commentedEntity = Mockery::mock(ContentEntityInterface::class);
    $variablesArray = $this->createVariablesArray();
    $variablesArray['comment'] = $comment;
    $variablesArray['commented_entity'] = $commentedEntity;
    $variablesArray['view_mode'] = $comment->getViewMode();

    /** @var \Drupal\preprocess_event_dispatcher\Variables\CommentEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(CommentPreprocessEvent::class, $variablesArray);
    self::assertInstanceOf(CommentEventVariables::class, $variables);
    $this->assertAbstractEntityEventVariables($variables, $comment);
    self::assertSame($comment, $variables->getComment());
    self::assertSame($commentedEntity, $variables->getCommentedEntity());
  }

  /**
   * Test a EckEntityPreprocessEvent.
   */
  public function testEckEntityEvent(): void {
    $eckEntity = EntityMockFactory::getMock(EckEntityInterface::class, 'eck_entity', 'eck_entity_bundle', 'eck_entity_view_mode');
    $variablesArray = $this->createVariablesArray();

    $variablesArray['eck_entity'] = $eckEntity;
    $variablesArray['elements'] = [
      '#view_mode' => $eckEntity->getViewMode(),
    ];
    $variablesArray['theme_hook_original'] = $eckEntity->getEntityType();
    $variablesArray['bundle'] = $eckEntity->bundle();

    /** @var \Drupal\preprocess_event_dispatcher\Variables\EckEntityEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(EckEntityPreprocessEvent::class, $variablesArray);
    self::assertInstanceOf(EckEntityEventVariables::class, $variables);
    $this->assertAbstractEntityEventVariables($variables, $eckEntity);
    self::assertSame($eckEntity, $variables->getEckEntity());
  }

  /**
   * Test a NodePreprocessEvent.
   */
  public function testNodeEvent(): void {
    $node = EntityMockFactory::getMock(NodeInterface::class, 'node', 'node_bundle', 'node_view_mode');
    $variablesArray = $this->createVariablesArray();
    $variablesArray['node'] = $node;
    $variablesArray['theme_hook_original'] = $node->getEntityType();
    $variablesArray['view_mode'] = $node->getViewMode();

    /** @var \Drupal\preprocess_event_dispatcher\Variables\NodeEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(NodePreprocessEvent::class, $variablesArray);
    self::assertInstanceOf(NodeEventVariables::class, $variables);
    $this->assertAbstractEntityEventVariables($variables, $node);
    self::assertSame($node, $variables->getNode());
  }

  /**
   * Test a ParagraphPreprocessEvent.
   */
  public function testParagraphEvent(): void {
    $paragraph = EntityMockFactory::getMock(ParagraphInterface::class, 'paragraph', 'paragraph_bundle', 'paragraph_view_mode');
    $variablesArray = $this->createVariablesArray();
    $variablesArray['paragraph'] = $paragraph;
    $variablesArray['theme_hook_original'] = $paragraph->getEntityType();
    $variablesArray['view_mode'] = $paragraph->getViewMode();

    /** @var \Drupal\preprocess_event_dispatcher\Variables\ParagraphEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(ParagraphPreprocessEvent::class, $variablesArray);
    self::assertInstanceOf(ParagraphEventVariables::class, $variables);
    $this->assertAbstractEntityEventVariables($variables, $paragraph);
    self::assertSame($paragraph, $variables->getParagraph());
  }

  /**
   * Test a TaxonomyTermPreprocessEvent.
   */
  public function testTaxonomyTermEvent(): void {
    $term = EntityMockFactory::getMock(TermInterface::class, 'taxonomy_term', 'term_bundle', 'term_view_mode');
    $variablesArray = $this->createVariablesArray();
    $variablesArray['term'] = $term;
    $variablesArray['theme_hook_original'] = $term->getEntityType();
    $variablesArray['view_mode'] = $term->getViewMode();

    /** @var \Drupal\preprocess_event_dispatcher\Variables\TaxonomyTermEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(TaxonomyTermPreprocessEvent::class, $variablesArray);
    self::assertInstanceOf(TaxonomyTermEventVariables::class, $variables);
    $this->assertAbstractEntityEventVariables($variables, $term);
    self::assertSame($term, $variables->getTerm());
  }

  /**
   * Test the default entity event variable methods.
   *
   * @param \Drupal\preprocess_event_dispatcher\Variables\AbstractEntityEventVariables $variables
   *   Variables object.
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   Entity mock.
   */
  private function assertAbstractEntityEventVariables(AbstractEntityEventVariables $variables, EntityInterface $entity): void {
    $this->assertAbstractEventVariables($variables);

    self::assertSame($entity, $variables->getEntity());
    self::assertSame($entity->getEntityType(), $variables->getEntityType());
    self::assertSame($entity->bundle(), $variables->getEntityBundle());
    self::assertSame($entity->getViewMode(), $variables->getViewMode());
  }

  /**
   * Test the default event variable methods.
   *
   * @param \Drupal\preprocess_event_dispatcher\Variables\AbstractEntityEventVariables $variables
   *   Variables object.
   */
  private function assertAbstractEventVariables(AbstractEntityEventVariables $variables): void {
    self::assertSame('success', $variables->get('test'));
    self::assertSame('default', $variables->get('test2', 'default'));

    $reference = &$variables->getByReference('reference');
    self::assertSame('first', $reference);
    $reference = 'second';
    self::assertSame('second', $variables->get('reference'));

    $variables->set('test3', 'new set');
    self::assertSame('new set', $variables->get('test3'));

    $variables->remove('test');
    self::assertNull($variables->get('test'));
  }

  /**
   * Get the variables from the created event.
   *
   * @param string $class
   *   Event class name.
   * @param array $variablesArray
   *   Variables array.
   *
   * @return \Drupal\preprocess_event_dispatcher\Variables\AbstractEntityEventVariables
   *   Variables object.
   */
  private function getVariablesFromCreatedEvent(string $class, array $variablesArray): AbstractEntityEventVariables {
    /** @var \Drupal\preprocess_event_dispatcher\Event\PreprocessEventInterface $class */
    $hook = $class::getHook();
    self::assertSame(AbstractPreprocessEvent::DISPATCH_NAME_PREFIX . $hook, $class::name());

    $factory = $this->mapper->getFactory($hook);
    self::assertSame($hook, $factory->getEventHook());

    /** @var \Drupal\preprocess_event_dispatcher\Event\PreprocessEntityEventInterface $event*/
    $event = $factory->createEvent($variablesArray);
    self::assertInstanceOf(PreprocessEntityEventInterface::class, $event);
    self::assertInstanceOf($class, $event);

    /** @var \Drupal\preprocess_event_dispatcher\Variables\AbstractEntityEventVariables $variables */
    $variables = $event->getVariables();
    self::assertInstanceOf(AbstractEntityEventVariables::class, $variables);

    return $variables;
  }

  /**
   * Create the variables array.
   *
   * @return array
   *   Variables array.
   */
  private function createVariablesArray(): array {
    return [
      'test' => 'success',
      'reference' => 'first',
    ];
  }

}
