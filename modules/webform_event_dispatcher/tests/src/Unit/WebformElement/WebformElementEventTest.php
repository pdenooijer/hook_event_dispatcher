<?php

namespace Drupal\Tests\webform_event_dispatcher\Unit\WebformElement;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;
use Drupal\webform_event_dispatcher\Event\WebformElement\WebformElementAlterEvent;
use Drupal\webform_event_dispatcher\Event\WebformElement\WebformElementInfoAlterEvent;
use Drupal\webform_event_dispatcher\Event\WebformElement\WebformElementTypeAlterEvent;

/**
 * Class WebformElementEventTest.
 *
 * @package Drupal\Tests\webform_event_dispatcher\Unit\Element
 *
 * @group hook_event_dispatcher
 */
class WebformElementEventTest extends UnitTestCase {

  /**
   * The manager.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy
   */
  private $manager;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $this->manager->setMaxEventCount(2);
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    \Drupal::setContainer($builder);
  }

  /**
   * Test WebformElementInfoAlterEvent.
   */
  public function testWebformElementInfoAlterEvent() {
    $definitions = ['textfield' => ['id' => 'textfield']];
    $alters = ['textfield' => ['#test' => 'test']];
    $expectedDefinitions = array_merge_recursive($definitions, $alters);

    // Create event subscriber to alter element info.
    $this->manager->setEventCallbacks([
      'hook_event_dispatcher.webform.element.info.alter' => function (WebformElementInfoAlterEvent $event) {
        $definitions = &$event->getDefinitions();
        $definitions['textfield']['#test'] = 'test';
      },
    ]);

    webform_event_dispatcher_webform_element_info_alter($definitions);

    /* @var \Drupal\webform_event_dispatcher\Event\WebformElement\WebformElementInfoAlterEvent $event */
    $event = $this->manager->getRegisteredEvent('hook_event_dispatcher.webform.element.info.alter');
    $this->assertInstanceOf(WebformElementInfoAlterEvent::class, $event);
    $this->assertSame($expectedDefinitions, $event->getDefinitions());
  }

  /**
   * Test WebformElementAlterEvent.
   */
  public function testWebformElementAlterEvent() {
    $element = ['#type' => 'textfield'];
    $alters = ['#test' => 'test'];
    $expectedElement = array_merge($element, $alters);
    $formState = $this->createMock(FormStateInterface::class);
    $context = ['form' => ['#webform_id' => 'test_form']];

    // Create event subscriber to alter element.
    $this->manager->setEventCallbacks([
      'hook_event_dispatcher.webform.element.alter' => function (WebformElementAlterEvent $event) {
        $element = &$event->getElement();
        $element['#test'] = 'test';
      },
    ]);

    webform_event_dispatcher_webform_element_alter($element, $formState, $context);

    /* @var \Drupal\webform_event_dispatcher\Event\WebformElement\WebformElementAlterEvent $event */
    $event = $this->manager->getRegisteredEvent('hook_event_dispatcher.webform.element.alter');
    $this->assertInstanceOf(WebformElementAlterEvent::class, $event);
    $this->assertSame($expectedElement, $event->getElement());
    $this->assertSame($formState, $event->getFormState());
    $this->assertSame($context, $event->getContext());
  }

  /**
   * Test WebformElementTypeAlterEvent.
   */
  public function testWebformElementTypeAlterEvent() {
    $elementType = 'textfield';
    $element = ['#type' => $elementType];
    $alters = ['#test' => 'test'];
    $expectedElement = array_merge($element, $alters);
    $formState = $this->createMock(FormStateInterface::class);
    $context = ['form' => ['#webform_id' => 'test_form']];

    // Create event subscriber to alter element of given type.
    $this->manager->setEventCallbacks([
      "hook_event_dispatcher.webform.element_$elementType.alter" => function (WebformElementAlterEvent $event) {
        $element = &$event->getElement();
        $element['#test'] = 'test';
      },
    ]);

    webform_event_dispatcher_webform_element_alter($element, $formState, $context);

    /* @var \Drupal\webform_event_dispatcher\Event\WebformElement\WebformElementTypeAlterEvent $event */
    $event = $this->manager->getRegisteredEvent("hook_event_dispatcher.webform.element_$elementType.alter");
    $this->assertInstanceOf(WebformElementTypeAlterEvent::class, $event);
    $this->assertSame($expectedElement, $event->getElement());
    $this->assertSame($elementType, $event->getElementType());
    $this->assertSame($formState, $event->getFormState());
    $this->assertSame($context, $event->getContext());
  }

}
