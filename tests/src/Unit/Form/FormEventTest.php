<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Form;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

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
  public function setUp() {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    \Drupal::setContainer($builder);
  }

  /**
   * Test FormAlterEvent.
   */
  public function testFormAlterEvent() {
    $form = ['test' => 'form'];
    $formState = $this->createMock(FormStateInterface::class);
    $formId = 'test_form';

    $this->manager->setMaxEventCount(2);

    hook_event_dispatcher_form_alter($form, $formState, $formId);

    /* @var \Drupal\hook_event_dispatcher\Event\Form\FormAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::FORM_ALTER);
    $this->assertEquals($form, $event->getForm());
    $this->assertEquals($formState, $event->getFormState());
    $this->assertEquals($formId, $event->getFormId());

    $newForm = ['NewForm'];
    $event->setForm($newForm);
    $this->assertEquals($newForm, $event->getForm());
  }

  /**
   * Test FormBaseAlterEvent.
   */
  public function testFormBaseAlterEvent() {
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
  public function testFormIdAlterEvent() {
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
  public function testWidgetFormAlterEvent() {
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

    /* @var \Drupal\hook_event_dispatcher\Event\Form\WidgetFormAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::WIDGET_FORM_ALTER);
    $this->assertEquals($element, $event->getElement());
    $this->assertEquals($formState, $event->getFormState());
    $this->assertEquals($context, $event->getContext());

    $newElement = ['NewElement'];
    $event->setElement($newElement);
    $this->assertEquals($newElement, $event->getElement());
  }

  /**
   * Test WidgetTypeFormAlterEvent.
   */
  public function testWidgetTypeFormAlterEvent() {
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
