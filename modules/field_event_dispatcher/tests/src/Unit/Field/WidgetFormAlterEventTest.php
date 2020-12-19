<?php

namespace Drupal\Tests\field_event_dispatcher\Unit\Field;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\field_event_dispatcher\Event\Field\WidgetFormAlterEvent;
use Drupal\field_event_dispatcher\Event\Field\WidgetMultivalueFormAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function field_event_dispatcher_field_widget_form_alter;
use function field_event_dispatcher_field_widget_multivalue_form_alter;

/**
 * Class WidgetFormAlterEventTest.
 *
 * @group field_event_dispatcher
 */
final class WidgetFormAlterEventTest extends TestCase {

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

    field_event_dispatcher_field_widget_form_alter($element, $formState, $context);

    $expectedElement['other'] = 'key';
    self::assertSame($expectedElement, $element);

    /** @var \Drupal\field_event_dispatcher\Event\Field\WidgetFormAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::WIDGET_FORM_ALTER);
    self::assertSame($element, $event->getElement());
    self::assertSame($formState, $event->getFormState());
    self::assertSame($context, $event->getContext());
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

    field_event_dispatcher_field_widget_form_alter($element, $formState, $context);

    /** @var \Drupal\field_event_dispatcher\Event\Field\WidgetTypeFormAlterEvent $event */
    $event = $this->manager->getRegisteredEvent("hook_event_dispatcher.widget_$widgetType.alter");
    self::assertSame($element, $event->getElement());
    self::assertSame($formState, $event->getFormState());
    self::assertSame($context, $event->getContext());
  }

  /**
   * Test WidgetMultivalueFormAlterEvent.
   */
  public function testWidgetMultivalueFormAlterEvent() :void {
    $elements = $expectedElements = [0 => ['widget' => 'element']];
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
      HookEventDispatcherInterface::WIDGET_MULTIVALUE_FORM_ALTER => static function (WidgetMultivalueFormAlterEvent $event) {
        $elements = &$event->getElements();
        $elements[0]['other'] = 'key';
      },
    ]);
    $this->manager->setMaxEventCount(2);

    field_event_dispatcher_field_widget_multivalue_form_alter($elements, $formState, $context);

    $expectedElements[0]['other'] = 'key';
    self::assertSame($expectedElements, $elements);

    /** @var \Drupal\field_event_dispatcher\Event\Field\WidgetFormAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::WIDGET_MULTIVALUE_FORM_ALTER);
    self::assertSame($elements, $event->getElements());
    self::assertSame($formState, $event->getFormState());
    self::assertSame($context, $event->getContext());
  }

}
