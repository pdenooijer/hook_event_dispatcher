<?php

namespace Drupal\Tests\preprocess_event_dispatcher\Unit;

use Drupal\block\BlockInterface;
use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\BlockPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\FieldPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\FormPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\HtmlPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\ImagePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\PagePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\StatusMessagesPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\UsernamePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\ViewFieldPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\ViewPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\ViewTablePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\AbstractEventVariables;
use Drupal\preprocess_event_dispatcher\Variables\BlockEventVariables;
use Drupal\preprocess_event_dispatcher\Variables\FieldEventVariables;
use Drupal\preprocess_event_dispatcher\Variables\FormEventVariables;
use Drupal\preprocess_event_dispatcher\Variables\HtmlEventVariables;
use Drupal\preprocess_event_dispatcher\Variables\ImageEventVariables;
use Drupal\preprocess_event_dispatcher\Variables\PageEventVariables;
use Drupal\preprocess_event_dispatcher\Variables\StatusMessagesEventVariables;
use Drupal\preprocess_event_dispatcher\Variables\UsernameEventVariables;
use Drupal\preprocess_event_dispatcher\Variables\ViewEventVariables;
use Drupal\preprocess_event_dispatcher\Variables\ViewFieldEventVariables;
use Drupal\preprocess_event_dispatcher\Variables\ViewTableEventVariables;
use Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers\YamlDefinitionsLoader;
use Drupal\Tests\UnitTestCase;
use Drupal\user\UserInterface;
use Drupal\views\Plugin\views\field\EntityField;
use Drupal\views\Plugin\views\field\Markup;
use Drupal\views\ResultRow;
use Drupal\views\ViewExecutable;
use Mockery;

/**
 * Class OtherEventVariablesTest.
 *
 * @group preprocess_event_dispatcher
 *
 * Testing the other events gives expected PHPMD warnings.
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
final class OtherEventVariablesTest extends UnitTestCase {

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
   * Test a BlockPreprocessEvent.
   */
  public function testBlockEvent(): void {
    $variablesArray = $this->createVariablesArray();
    $block = Mockery::mock(BlockInterface::class);
    $variablesArray['block'] = $block;
    $variablesArray['elements']['#id'] = '22';
    $variablesArray['content']['test'] = ['success2'];

    /* @var \Drupal\preprocess_event_dispatcher\Variables\BlockEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(BlockPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(BlockEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    $this->assertSame($block, $variables->getBlock());
    $this->assertSame('22', $variables->getId());
    $this->assertSame(['success2'], $variables->getContentChild('test'));
    $this->assertSame([], $variables->getContentChild('none-existing'));
  }

  /**
   * Test a FieldPreprocessEvent.
   */
  public function testFieldEvent(): void {
    $variablesArray = $this->createVariablesArray();
    $variablesArray['element'] = ['element array'];
    $variablesArray['items'] = ['items array'];

    /* @var \Drupal\preprocess_event_dispatcher\Variables\FieldEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(FieldPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(FieldEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    $this->assertSame(['element array'], $variables->getElement());
    $this->assertSame(['items array'], $variables->getItems());
  }

  /**
   * Test FormPreprocessEvent.
   */
  public function testFormEvent(): void {
    $variablesArray = $this->createVariablesArray();
    $variablesArray['element'] = ['element array'];

    /* @var \Drupal\preprocess_event_dispatcher\Variables\FormEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(FormPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(FormEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    $this->assertSame(['element array'], $variables->getElement());
  }

  /**
   * Test a HtmlPreprocessEvent.
   */
  public function testHtmlEvent(): void {
    $variablesArray = $this->createVariablesArray();

    /* @var \Drupal\preprocess_event_dispatcher\Variables\HtmlEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(HtmlPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(HtmlEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
  }

  /**
   * Test a ImagePreprocessEvent.
   */
  public function testImageEvent(): void {
    $variablesArray = $this->createVariablesArray();

    /* @var \Drupal\preprocess_event_dispatcher\Variables\ImageEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(ImagePreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(ImageEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
  }

  /**
   * Test a PagePreprocessEvent.
   */
  public function testPageEvent(): void {
    $variablesArray['page'] = $this->createVariablesArray();

    /* @var \Drupal\preprocess_event_dispatcher\Variables\PageEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(PagePreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(PageEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
  }

  /**
   * Test a UsernamePreprocessEvent.
   */
  public function testUsernameEvent(): void {
    $variablesArray = $this->createVariablesArray();
    $accountMock = Mockery::mock(UserInterface::class);
    $accountMock->expects('isAnonymous')
      ->with()
      ->once()
      ->andReturnTrue();
    $variablesArray['account'] = $accountMock;

    /* @var \Drupal\preprocess_event_dispatcher\Variables\UsernameEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(UsernamePreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(UsernameEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    $this->assertSame($accountMock, $variables->getAccount());
    $this->assertTrue($variables->userIsAnonymous());
  }

  /**
   * Test a ViewFieldPreprocessEvent.
   */
  public function testViewFieldEvent(): void {
    $variablesArray = $this->createVariablesArray();
    $field = Mockery::mock(EntityField::class);
    $variablesArray['field'] = $field;
    $output = Mockery::mock(Markup::class);
    $variablesArray['output'] = $output;
    $row = Mockery::mock(ResultRow::class);
    $variablesArray['row'] = $row;
    $view = Mockery::mock(ViewExecutable::class);
    $variablesArray['view'] = $view;

    /* @var \Drupal\preprocess_event_dispatcher\Variables\ViewFieldEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(ViewFieldPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(ViewFieldEventVariables::class, $variables);

    $this->assertAbstractEventVariables($variables);
    $this->assertSame($field, $variables->getField());
    $this->assertSame($output, $variables->getOutput());
    $this->assertSame($row, $variables->getRow());
    $this->assertSame($view, $variables->getView());
  }

  /**
   * Test a ViewTablePreprocessEvent.
   */
  public function testViewTableEvent(): void {
    $variablesArray = $this->createVariablesArray();
    $rows = Mockery::mock(ResultRow::class);
    $variablesArray['rows'] = $rows;
    $view = Mockery::mock(ViewExecutable::class);
    $variablesArray['view'] = $view;

    /* @var \Drupal\preprocess_event_dispatcher\Variables\ViewTableEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(ViewTablePreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(ViewTableEventVariables::class, $variables);

    $this->assertAbstractEventVariables($variables);
    $this->assertSame($rows, $variables->getRows());
    $this->assertSame($view, $variables->getView());
  }

  /**
   * Test a ViewPreprocessEvent.
   */
  public function testViewEvent(): void {
    $variablesArray = $this->createVariablesArray();
    $variablesArray['rows'][0]['#rows'] = ['rows'];
    $view = Mockery::mock(ViewExecutable::class);
    $variablesArray['view'] = $view;

    /* @var \Drupal\preprocess_event_dispatcher\Variables\ViewEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(ViewPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(ViewEventVariables::class, $variables);

    $this->assertAbstractEventVariables($variables);
    $this->assertSame(['rows'], $variables->getRows());
    $this->assertSame($view, $variables->getView());
  }

  /**
   * Test a StatusMessagesPreprocessEvent.
   */
  public function testStatusMessagesEvent(): void {
    $variablesArray = $this->createVariablesArray();

    /* @var \Drupal\preprocess_event_dispatcher\Variables\StatusMessagesEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(StatusMessagesPreprocessEvent::class, $variablesArray);
    $this->assertInstanceOf(StatusMessagesEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
  }

  /**
   * Test the default event variable functions.
   *
   * @param \Drupal\preprocess_event_dispatcher\Variables\AbstractEventVariables $variables
   *   Variables object.
   */
  private function assertAbstractEventVariables(AbstractEventVariables $variables): void {
    $this->assertSame('success', $variables->get('test'));
    $this->assertSame('default', $variables->get('test2', 'default'));

    $reference = &$variables->getByReference('reference');
    $this->assertSame('first', $reference);
    $reference = 'second';
    $this->assertSame('second', $variables->get('reference'));

    $variables->set('test3', 'new set');
    $this->assertSame('new set', $variables->get('test3'));

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
   * @return \Drupal\preprocess_event_dispatcher\Variables\AbstractEventVariables
   *   Variables object.
   */
  private function getVariablesFromCreatedEvent(string $class, array $variablesArray): AbstractEventVariables {
    /* @var \Drupal\preprocess_event_dispatcher\Event\PreprocessEventInterface $class */
    $hook = $class::getHook();
    $this->assertSame(AbstractPreprocessEvent::DISPATCH_NAME_PREFIX . $hook, $class::name());

    $factory = $this->mapper->getFactory($hook);
    $this->assertSame($hook, $factory->getEventHook());

    /* @var \Drupal\preprocess_event_dispatcher\Event\PreprocessEventInterface $event*/
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
  private function createVariablesArray(): array {
    return [
      'test' => 'success',
      'reference' => 'first',
    ];
  }

}
