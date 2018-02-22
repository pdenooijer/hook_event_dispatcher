<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess;

use Drupal\hook_event_dispatcher\Event\Preprocess\AbstractPreprocessEvent;
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
use Drupal\hook_event_dispatcher\Event\Preprocess\UsernamePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\BlockEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\CommentEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\EckEntityEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\FieldEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\FormEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\HtmlEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ImageEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\NodeEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\PageEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ParagraphEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\TaxonomyTermEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\UsernameEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewFieldEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\ViewFieldPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ViewPreprocessEvent;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\YamlDefinitionsLoader;
use Drupal\Tests\UnitTestCase;
use Drupal\user\UserInterface;

/**
 * Class FactoryMapperTest.
 *
 * @group hook_event_dispatcher
 *
 * Testing all events gives expected PHPMD warnings.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class FactoryMapperTest extends UnitTestCase {

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
   * Test if all factories are in the YAML file.
   */
  public function testYamlHasAllFactories() {
    $factoriesYaml = YamlDefinitionsLoader::getInstance()->getFactories();
    $classNames = $this->getFactoryClassNamesFromFilesystem();

    $this->assertEquals(count($factoriesYaml), count($classNames));

    foreach ($factoriesYaml as $entry) {
      $this->assertContains($entry['class'], $classNames);
    }
  }

  /**
   * Get the Factory class names from the filesystems directory.
   *
   * @return array
   *   Class names array.
   */
  private function getFactoryClassNamesFromFilesystem() {
    $files = scandir(
      // Go to the project root directory.
      dirname(dirname(dirname(dirname(__DIR__)))) . '/src/Event/Preprocess/Factory',
      SCANDIR_SORT_NONE
    );

    $invalidFactories = [
      '.',
      '..',
      'PreprocessEventFactoryInterface.php',
    ];
    $files = array_filter($files, function ($file) use ($invalidFactories) {
      return !in_array($file, $invalidFactories, TRUE);
    });

    $classNames = [];
    foreach ($files as $file) {
      $classNames[] = '\\Drupal\\hook_event_dispatcher\\Event\\Preprocess\\Factory\\' . substr($file, 0, -4);
    }
    return $classNames;
  }

  /**
   * Test a none existing hook.
   */
  public function testNoneExistingHook() {
    $factory = $this->mapper->getFactory('NoneExistingHook');
    $this->assertEquals(NULL, $factory);
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
   * Test a FieldPreprocessEvent.
   */
  public function testFieldEvent() {
    $variablesArray = $this->createVariablesArray();
    $variablesArray['element'] = ['element array'];
    $variablesArray['items'] = ['items array'];

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\FieldEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(FieldPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(FieldEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    $this->assertEquals(['element array'], $variables->getElement());
    $this->assertEquals(['items array'], $variables->getItems());
  }

  /**
   * Test FormPreprocessEvent.
   */
  public function testFormEvent() {
    $variablesArray = $this->createVariablesArray();
    $variablesArray['element'] = ['element array'];

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\FormEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(FormPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(FormEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    $this->assertEquals(['element array'], $variables->getElement());
  }

  /**
   * Test a HtmlPreprocessEvent.
   */
  public function testHtmlEvent() {
    $variablesArray = $this->createVariablesArray();

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\HtmlEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(HtmlPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(HtmlEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
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
   * Test a PagePreprocessEvent.
   */
  public function testPageEvent() {
    $variablesArray['page'] = $this->createVariablesArray();

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\PageEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(PagePreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(PageEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
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
   * Test a UsernamePreprocessEvent.
   */
  public function testUsernameEvent() {
    $variablesArray = $this->createVariablesArray();
    $accountMock = $this->getMockBuilder(UserInterface::class)
      ->disableOriginalClone()
      ->disableOriginalConstructor()
      ->setMethods(['isAnonymous'])
      ->getMock();
    $accountMock->expects($this->once())
      ->method('isAnonymous')
      ->with()
      ->willReturn(TRUE);
    $variablesArray['account'] = $accountMock;

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\UsernameEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(UsernamePreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(UsernameEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    $this->assertEquals($accountMock, $variables->getAccount());
    $this->assertTrue($variables->userIsAnonymous());
  }

  /**
   * Test a ViewFieldPreprocessEvent.
   */
  public function testViewFieldEvent() {
    $variablesArray = $this->createVariablesArray();
    $variablesArray['field'] = 'field';
    $variablesArray['output'] = 'output';
    $variablesArray['row'] = 'row';
    $variablesArray['view'] = 'view';

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewFieldEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(ViewFieldPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(ViewFieldEventVariables::class, $variables);

    $this->assertAbstractEventVariables($variables);
    $this->assertEquals('field', $variables->getField());
    $this->assertEquals('output', $variables->getOutput());
    $this->assertEquals('row', $variables->getRow());
    $this->assertEquals('view', $variables->getView());
  }

  /**
   * Test a ViewPreprocessEvent.
   */
  public function testViewEvent() {
    $variablesArray = $this->createVariablesArray();
    $variablesArray['rows'][0]['#rows'] = ['rows'];
    $variablesArray['view'] = 'view';

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(ViewPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(ViewEventVariables::class, $variables);

    $this->assertAbstractEventVariables($variables);
    $this->assertEquals(['rows'], $variables->getRows());
    $this->assertEquals('view', $variables->getView());
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
