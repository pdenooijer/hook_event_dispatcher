<?php

namespace Drupal\Tests\webform_event_dispatcher\Unit\WebformElement;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\webform_event_dispatcher\Event\WebformElement\WebformElementAlterEvent;
use Drupal\webform_event_dispatcher\Event\WebformElement\WebformElementInfoAlterEvent;
use Drupal\webform_event_dispatcher\Event\WebformElement\WebformElementTypeAlterEvent;
use PHPUnit\Framework\TestCase;
use function array_merge;
use function array_merge_recursive;

/**
 * Class WebformElementEventTest.
 *
 * @group hook_event_dispatcher
 */
class WebformElementEventTest extends TestCase {

  /**
   * The manager.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy
   */
  private $manager;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $this->manager->setMaxEventCount(2);
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    Drupal::setContainer($builder);
  }

  /**
   * Test WebformElementInfoAlterEvent.
   */
  public function testWebformElementInfoAlterEvent(): void {
    $definitions = ['textfield' => ['id' => 'textfield']];
    $alters = ['textfield' => ['#test' => 'test']];
    $expectedDefinitions = array_merge_recursive($definitions, $alters);

    // Create event subscriber to alter element info.
    $this->manager->setEventCallbacks([
      'hook_event_dispatcher.webform.element.info.alter' => static function (WebformElementInfoAlterEvent $event) {
        $definitions = &$event->getDefinitions();
        $definitions['textfield']['#test'] = 'test';
      },
    ]);

    webform_event_dispatcher_webform_element_info_alter($definitions);

    /** @var \Drupal\webform_event_dispatcher\Event\WebformElement\WebformElementInfoAlterEvent $event */
    $event = $this->manager->getRegisteredEvent('hook_event_dispatcher.webform.element.info.alter');
    self::assertInstanceOf(WebformElementInfoAlterEvent::class, $event);
    self::assertSame($expectedDefinitions, $event->getDefinitions());
  }

  /**
   * Test WebformElementAlterEvent.
   */
  public function testWebformElementAlterEvent(): void {
    $element = ['#type' => 'textfield'];
    $alters = ['#test' => 'test'];
    $expectedElement = array_merge($element, $alters);
    $formState = $this->createMock(FormStateInterface::class);
    $context = ['form' => ['#webform_id' => 'test_form']];

    // Create event subscriber to alter element.
    $this->manager->setEventCallbacks([
      'hook_event_dispatcher.webform.element.alter' => static function (WebformElementAlterEvent $event) {
        $element = &$event->getElement();
        $element['#test'] = 'test';
      },
    ]);

    webform_event_dispatcher_webform_element_alter($element, $formState, $context);

    /** @var \Drupal\webform_event_dispatcher\Event\WebformElement\WebformElementAlterEvent $event */
    $event = $this->manager->getRegisteredEvent('hook_event_dispatcher.webform.element.alter');
    self::assertInstanceOf(WebformElementAlterEvent::class, $event);
    self::assertSame($expectedElement, $event->getElement());
    self::assertSame($formState, $event->getFormState());
    self::assertSame($context, $event->getContext());
  }

  /**
   * Test WebformElementTypeAlterEvent.
   */
  public function testWebformElementTypeAlterEvent(): void {
    $elementType = 'textfield';
    $element = ['#type' => $elementType];
    $alters = ['#test' => 'test'];
    $expectedElement = array_merge($element, $alters);
    $formState = $this->createMock(FormStateInterface::class);
    $context = ['form' => ['#webform_id' => 'test_form']];

    // Create event subscriber to alter element of given type.
    $this->manager->setEventCallbacks([
      "hook_event_dispatcher.webform.element_$elementType.alter" => static function (WebformElementAlterEvent $event) {
        $element = &$event->getElement();
        $element['#test'] = 'test';
      },
    ]);

    webform_event_dispatcher_webform_element_alter($element, $formState, $context);

    /** @var \Drupal\webform_event_dispatcher\Event\WebformElement\WebformElementTypeAlterEvent $event */
    $event = $this->manager->getRegisteredEvent("hook_event_dispatcher.webform.element_$elementType.alter");
    self::assertInstanceOf(WebformElementTypeAlterEvent::class, $event);
    self::assertSame($expectedElement, $event->getElement());
    self::assertSame($elementType, $event->getElementType());
    self::assertSame($formState, $event->getFormState());
    self::assertSame($context, $event->getContext());
  }

}
