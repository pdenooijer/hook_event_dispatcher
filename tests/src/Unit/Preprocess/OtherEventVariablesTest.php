<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess;

use Drupal\hook_event_dispatcher\Event\Preprocess\AbstractPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\BlockPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\FieldPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\FormPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\HtmlPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ImagePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\PagePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\StatusMessagesPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\UsernamePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\BlockEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\FieldEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\FormEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\HtmlEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ImageEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\PageEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\StatusMessagesEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\UsernameEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewFieldEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewTableEventVariables;
use Drupal\hook_event_dispatcher\Event\Preprocess\ViewFieldPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ViewTablePreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\ViewPreprocessEvent;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\YamlDefinitionsLoader;
use Drupal\Tests\UnitTestCase;
use Drupal\user\UserInterface;

/**
 * Class OtherEventVariablesTest.
 *
 * @group hook_event_dispatcher
 *
 * Testing the other events gives expected PHPMD warnings.
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
final class OtherEventVariablesTest extends UnitTestCase {

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
    $variablesArray['block'] = 'block';
    $variablesArray['elements']['#id'] = 22;
    $variablesArray['content']['test'] = ['success2'];

    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\BlockEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(BlockPreprocessEvent::class, $variablesArray);
    self::assertInstanceOf(BlockEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    self::assertSame('block', $variables->getBlock());
    self::assertEquals(22, $variables->getId());
    self::assertEquals(['success2'], $variables->getContentChild('test'));
    self::assertEquals([], $variables->getContentChild('none-existing'));
  }

  /**
   * Test a FieldPreprocessEvent.
   */
  public function testFieldEvent() {
    $variablesArray = $this->createVariablesArray();
    $variablesArray['element'] = ['element array'];
    $variablesArray['items'] = ['items array'];

    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\FieldEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(FieldPreprocessEvent::class, $variablesArray);
    self::assertInstanceOf(FieldEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    self::assertEquals(['element array'], $variables->getElement());
    self::assertEquals(['items array'], $variables->getItems());
  }

  /**
   * Test FormPreprocessEvent.
   */
  public function testFormEvent() {
    $variablesArray = $this->createVariablesArray();
    $variablesArray['element'] = ['element array'];

    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\FormEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(FormPreprocessEvent::class, $variablesArray);
    self::assertInstanceOf(FormEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    self::assertEquals(['element array'], $variables->getElement());
  }

  /**
   * Test a HtmlPreprocessEvent.
   */
  public function testHtmlEvent() {
    $variablesArray = $this->createVariablesArray();

    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\HtmlEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(HtmlPreprocessEvent::class, $variablesArray);
    self::assertInstanceOf(HtmlEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
  }

  /**
   * Test a ImagePreprocessEvent.
   */
  public function testImageEvent() {
    $variablesArray = $this->createVariablesArray();

    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ImageEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(ImagePreprocessEvent::class, $variablesArray);
    self::assertInstanceOf(ImageEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
  }

  /**
   * Test a PagePreprocessEvent.
   */
  public function testPageEvent() {
    $variablesArray = [];
    $variablesArray['page'] = $this->createVariablesArray();

    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\PageEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(PagePreprocessEvent::class, $variablesArray);
    self::assertInstanceOf(PageEventVariables::class, $variables);
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

    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\UsernameEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(UsernamePreprocessEvent::class, $variablesArray);
    self::assertInstanceOf(UsernameEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
    self::assertEquals($accountMock, $variables->getAccount());
    self::assertTrue($variables->userIsAnonymous());
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

    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewFieldEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(ViewFieldPreprocessEvent::class, $variablesArray);
    self::assertInstanceOf(ViewFieldEventVariables::class, $variables);

    $this->assertAbstractEventVariables($variables);
    self::assertEquals('field', $variables->getField());
    self::assertEquals('output', $variables->getOutput());
    self::assertEquals('row', $variables->getRow());
    self::assertEquals('view', $variables->getView());
  }

  /**
   * Test a ViewTablePreprocessEvent.
   */
  public function testViewTableEvent() {
    $variablesArray = $this->createVariablesArray();
    $variablesArray['rows'] = 'rows';
    $variablesArray['view'] = 'view';

    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewTableEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(ViewTablePreprocessEvent::class, $variablesArray);
    self::assertInstanceOf(ViewTableEventVariables::class, $variables);

    $this->assertAbstractEventVariables($variables);
    self::assertSame('rows', $variables->getRows());
    self::assertSame('view', $variables->getView());
  }

  /**
   * Test a ViewPreprocessEvent.
   */
  public function testViewEvent() {
    $variablesArray = $this->createVariablesArray();
    $variablesArray['rows'][0]['#rows'] = ['rows'];
    $variablesArray['view'] = 'view';

    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ViewEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(ViewPreprocessEvent::class, $variablesArray);
    self::assertInstanceOf(ViewEventVariables::class, $variables);

    $this->assertAbstractEventVariables($variables);
    self::assertEquals(['rows'], $variables->getRows());
    self::assertEquals('view', $variables->getView());
  }

  /**
   * Test a StatusMessagesPreprocessEvent.
   */
  public function testStatusMessagesEvent() {
    $variablesArray = $this->createVariablesArray();

    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\StatusMessagesEventVariables $variables */
    $variables = $this->getVariablesFromCreatedEvent(StatusMessagesPreprocessEvent::class, $variablesArray);
    self::assertInstanceOf(StatusMessagesEventVariables::class, $variables);
    $this->assertAbstractEventVariables($variables);
  }

  /**
   * Test the default event variable functions.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables $variables
   *   Variables object.
   */
  private function assertAbstractEventVariables(AbstractEventVariables $variables) {
    self::assertEquals('success', $variables->get('test'));
    self::assertEquals('default', $variables->get('test2', 'default'));

    $reference = &$variables->getByReference('reference');
    self::assertEquals('first', $reference);
    $reference = 'second';
    self::assertEquals('second', $variables->get('reference'));

    $variables->set('test3', 'new set');
    self::assertEquals('new set', $variables->get('test3'));

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
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\AbstractEventVariables
   *   Variables object.
   */
  private function getVariablesFromCreatedEvent($class, array $variablesArray) {
    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\PreprocessEventInterface $class */
    $hook = $class::getHook();
    self::assertEquals(AbstractPreprocessEvent::DISPATCH_NAME_PREFIX . $hook, $class::name());

    $factory = $this->mapper->getFactory($hook);
    self::assertEquals($hook, $factory->getEventHook());

    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\PreprocessEventInterface $event*/
    $event = $factory->createEvent($variablesArray);
    self::assertInstanceOf($class, $event);

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
