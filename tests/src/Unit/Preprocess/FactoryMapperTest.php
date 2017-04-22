<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess;

use Drupal\hook_event_dispatcher\Event\Preprocess\BlockPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\EckEntityPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\FieldPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\FormPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\HtmlPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ImagePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\NodePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\PagePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ViewFieldPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ViewPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\BlockEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\EckEntityEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\FieldEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\FormEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\HtmlEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ImageEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\NodeEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\PageEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewFieldEventVariables;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\YamlDefinitionsLoader;

/**
 * Class FactoryMapperTest.
 */
final class FactoryMapperTest extends \PHPUnit_Framework_TestCase {

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
    $class_names = $this->getFactoryClassNamesFromFilesystem();

    $this->assertEquals(count($factoriesYaml), count($class_names));

    foreach ($factoriesYaml as $entry) {
      $this->assertContains($entry['class'], $class_names);
    }
  }

  /**
   * Get the Factory class names from the filesystems directory.
   *
   * @return array
   *   Class names array.
   */
  private function getFactoryClassNamesFromFilesystem() {
    $files = scandir(dirname(dirname(dirname(dirname(__DIR__)))) . '/src/Event/Preprocess/Factory');

    $invalid_factories = [
      '.',
      '..',
      'PreprocessEventFactoryInterface.php',
    ];
    $files = array_filter($files, function ($file) use ($invalid_factories) {
      return !in_array($file, $invalid_factories, TRUE);
    });

    $class_names = [];
    foreach ($files as $file) {
      $name = '\\Drupal\\hook_event_dispatcher\\Event\\Preprocess\\Factory\\' . substr($file, 0, -4);
      $class_names[] = $name;
    }
    return $class_names;
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
    $variables_array = $this->createVariablesArray();
    $variables_array['elements']['#id'] = 22;
    $variables_array['content']['test'] = 'success2';

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\BlockEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(BlockPreprocessEvent::class, $variables_array);
    $this->assertInstanceOf(BlockEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    $this->assertEquals(22, $variables->getId());
    $this->assertEquals('success2', $variables->getContentChild('test'));
  }

  /**
   * Test a EckEntityPreprocessEvent.
   */
  public function testEckEntityEvent() {
    $variables_array = $this->createVariablesArray();
    $variables_array['entity']['#entity'] = new \stdClass();
    $variables_array['entity']['#entity_type'] = 'test_type';

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\EckEntityEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(EckEntityPreprocessEvent::class, $variables_array);
    $this->assertInstanceOf(EckEntityEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    $this->assertInstanceOf(\stdClass::class, $variables->getEntity());
    $this->assertEquals('test_type', $variables->getEntityType());
  }

  /**
   * Test a FieldPreprocessEvent.
   */
  public function testFieldEvent() {
    $variables_array = $this->createVariablesArray();
    $variables_array['element'] = ['element array'];
    $variables_array['items'] = ['items array'];

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\FieldEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(FieldPreprocessEvent::class, $variables_array);
    $this->assertInstanceOf(FieldEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    $this->assertEquals(['element array'], $variables->getElement());
    $this->assertEquals(['items array'], $variables->getItems());
  }

  /**
   * Test FormPreprocessEvent.
   */
  public function testFormEvent() {
    $variables_array = $this->createVariablesArray();
    $variables_array['element'] = ['element array'];

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\FormEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(FormPreprocessEvent::class, $variables_array);
    $this->assertInstanceOf(FormEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    $this->assertEquals(['element array'], $variables->getElement());
  }

  /**
   * Test a HtmlPreprocessEvent.
   */
  public function testHtmlEvent() {
    $variables_array = $this->createVariablesArray();

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\HtmlEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(HtmlPreprocessEvent::class, $variables_array);
    $this->assertInstanceOf(HtmlEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
  }

  /**
   * Test a ImagePreprocessEvent.
   */
  public function testImageEvent() {
    $variables_array = $this->createVariablesArray();

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ImageEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(ImagePreprocessEvent::class, $variables_array);
    $this->assertInstanceOf(ImageEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
  }

  /**
   * Test a NodePreprocessEvent.
   */
  public function testNodeEvent() {
    $variables_array = $this->createVariablesArray();
    $variables_array['node'] = new \stdClass();

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\NodeEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(NodePreprocessEvent::class, $variables_array);
    $this->assertInstanceOf(NodeEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    $this->assertInstanceOf(\stdClass::class, $variables->getNode());
  }

  /**
   * Test a PagePreprocessEvent.
   */
  public function testPageEvent() {
    $variables_array['page']['test'] = 'success';

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\PageEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(PagePreprocessEvent::class, $variables_array);
    $this->assertInstanceOf(PageEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
  }

  /**
   * Test a ViewPreprocessEvent.
   */
  public function testViewEvent() {
    $variables_array = $this->createVariablesArray();
    $variables_array['rows'][0]['#rows'] = ['rows'];
    $variables_array['view'] = 'view';

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(ViewPreprocessEvent::class, $variables_array);
    $this->assertInstanceOf(ViewEventVariables::class, $variables);

    $this->assertAbstractEventVariables($variables);
    $this->assertEquals(['rows'], $variables->getRows());
    $this->assertEquals('view', $variables->getView());
  }

  /**
   * Test a ViewFieldPreprocessEvent.
   */
  public function testViewFieldEvent() {
    $variables_array = $this->createVariablesArray();
    $variables_array['field'] = 'field';
    $variables_array['output'] = 'output';
    $variables_array['row'] = 'row';
    $variables_array['view'] = 'view';

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewFieldEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(ViewFieldPreprocessEvent::class, $variables_array);
    $this->assertInstanceOf(ViewFieldEventVariables::class, $variables);

    $this->assertAbstractEventVariables($variables);
    $this->assertEquals('field', $variables->getField());
    $this->assertEquals('output', $variables->getOutput());
    $this->assertEquals('row', $variables->getRow());
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

    $variables->set('test3', 'new set');
    $this->assertEquals('new set', $variables->get('test3'));
  }

  /**
   * Get the variables from the created event.
   *
   * @param string $class
   *   Event class name.
   * @param array $variables_array
   *   Variables array.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables
   *   Variables object.
   */
  private function getVariablesFromCreatedEvent($class, array $variables_array) {
    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\PreprocessEventInterface $class */
    $factory = $this->mapper->getFactory($class::getHook());
    $this->assertEquals($class::getHook(), $factory->getEventHook());

    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\PreprocessEventInterface $event*/
    $event = $factory->createEvent($variables_array);
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
    return ['test' => 'success'];
  }

}
