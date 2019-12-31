<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Form;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\hook_event_dispatcher\Event\Form\FormAlterEvent;
use Drupal\hook_event_dispatcher\Event\Form\WidgetFormAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;
use function hook_event_dispatcher_field_widget_form_alter;
use function hook_event_dispatcher_form_alter;

/**
 * Class FormEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Form
 *
 * @group hook_event_dispatcher
 */
class FormEventTest extends UnitTestCase {

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
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    Drupal::setContainer($builder);
  }

  /**
   * Test FormAlterEvent.
   */
  public function testFormAlterEvent(): void {
    $form = $expectedForm = ['test' => 'form'];
    $formState = $this->createMock(FormStateInterface::class);
    $formId = 'test_form';

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::FORM_ALTER => static function (FormAlterEvent $event) {
        $form = &$event->getForm();
        $form['test2'] = 'test_altered';
      },
    ]);
    $this->manager->setMaxEventCount(2);

    hook_event_dispatcher_form_alter($form, $formState, $formId);

    $expectedForm['test2'] = 'test_altered';
    $this->assertSame($expectedForm, $form);

    /* @var \Drupal\hook_event_dispatcher\Event\Form\FormAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::FORM_ALTER);
    $this->assertSame($form, $event->getForm());
    $this->assertSame($formState, $event->getFormState());
    $this->assertSame($formId, $event->getFormId());
  }

  /**
   * Test FormBaseAlterEvent.
   */
  public function testFormBaseAlterEvent(): void {
    $baseFormId = 'test_base_form';
    $form = ['test' => 'form'];
    $buildInfo = ['base_form_id' => $baseFormId];
    $formState = $this->createMock(FormStateInterface::class);
    $formState->method('getBuildInfo')
      ->willReturn($buildInfo);
    $formId = 'test_form';

    $this->manager->setMaxEventCount(3);

    hook_event_dispatcher_form_alter($form, $formState, $formId);

    /* @var \Drupal\hook_event_dispatcher\Event\Form\FormBaseAlterEvent $event */
    $event = $this->manager->getRegisteredEvent("hook_event_dispatcher.form_base_$baseFormId.alter");
    $this->assertEquals($form, $event->getForm());
    $this->assertEquals($formState, $event->getFormState());
    $this->assertEquals($formId, $event->getFormId());
    $this->assertEquals($baseFormId, $event->getBaseFormId());
  }

  /**
   * Test FormIdAlterEvent.
   */
  public function testFormIdAlterEvent(): void {
    $form = ['test' => 'form'];
    $formState = $this->createMock(FormStateInterface::class);
    $formId = 'test_form';

    $this->manager->setMaxEventCount(2);

    hook_event_dispatcher_form_alter($form, $formState, $formId);

    /* @var \Drupal\hook_event_dispatcher\Event\Form\FormAlterEvent $event */
    $event = $this->manager->getRegisteredEvent("hook_event_dispatcher.form_$formId.alter");
    $this->assertEquals($form, $event->getForm());
    $this->assertEquals($formState, $event->getFormState());
    $this->assertEquals($formId, $event->getFormId());
  }

  /**
   * Test WidgetFormAlterEvent.
   */
  public function testWidgetFormAlterEvent(): void {
    $element = $expectedElement = ['widget' => 'element'];
    $formState = $this->createMock(FormStateInterface::class);
    $items = $this->createMock(FieldItemListInterface::class);
    $definition = $this->createMock(FieldDefinitionInterface::class);
    $widgetType = 'widget_type';
    $definition->method('getType')
      ->willReturn($widgetType);
    $items->method('getFieldDefinition')
      ->willReturn($definition);
    $context = ['items' => $items];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::WIDGET_FORM_ALTER => static function (WidgetFormAlterEvent $event) {
        $element = &$event->getElement();
        $element['other'] = 'key';
      },
    ]);
    $this->manager->setMaxEventCount(2);

    hook_event_dispatcher_field_widget_form_alter($element, $formState, $context);

    $expectedElement['other'] = 'key';
    $this->assertSame($expectedElement, $element);

    /* @var \Drupal\hook_event_dispatcher\Event\Form\WidgetFormAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::WIDGET_FORM_ALTER);
    $this->assertEquals($element, $event->getElement());
    $this->assertEquals($formState, $event->getFormState());
    $this->assertEquals($context, $event->getContext());
  }

  /**
   * Test WidgetTypeFormAlterEvent.
   */
  public function testWidgetTypeFormAlterEvent(): void {
    $element = ['widget' => 'element'];
    $formState = $this->createMock(FormStateInterface::class);
    $items = $this->createMock(FieldItemListInterface::class);
    $definition = $this->createMock(FieldDefinitionInterface::class);
    $widgetType = 'widget_type';
    $definition->method('getType')
      ->willReturn($widgetType);
    $items->method('getFieldDefinition')
      ->willReturn($definition);
    $context = ['items' => $items];

    $this->manager->setMaxEventCount(2);

    hook_event_dispatcher_field_widget_form_alter($element, $formState, $context);

    /* @var \Drupal\hook_event_dispatcher\Event\Form\WidgetTypeFormAlterEvent $event */
    $event = $this->manager->getRegisteredEvent("hook_event_dispatcher.widget_$widgetType.alter");
    $this->assertEquals($element, $event->getElement());
    $this->assertEquals($formState, $event->getFormState());
    $this->assertEquals($context, $event->getContext());
  }

}
