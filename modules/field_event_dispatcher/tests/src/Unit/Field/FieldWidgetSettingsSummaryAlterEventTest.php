<?php

namespace Drupal\Tests\field_event_dispatcher\Unit\Field;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Field\Plugin\Field\FieldWidget\StringTextfieldWidget;
use Drupal\field_event_dispatcher\Event\Field\FieldWidgetSettingsSummaryAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;
use function field_event_dispatcher_field_widget_settings_summary_alter;

/**
 * Class FieldWidgetSettingsSummaryAlterEventTest.
 *
 * @group field_event_dispatcher
 */
class FieldWidgetSettingsSummaryAlterEventTest extends UnitTestCase {

  /**
   * The manager.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy
   */
  private $manager;

  /**
   * Sets up the test.
   */
  public function setUp() {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    Drupal::setContainer($builder);
  }

  /**
   * FieldWidgetSettingsSummaryAlterEventTest adding summary test.
   *
   * This tests adding an additional summary.
   */
  public function testAddSummary() {
    $summary = $expectedSummary = [];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::FIELD_WIDGET_SETTINGS_SUMMARY_ALTER => static function (
        FieldWidgetSettingsSummaryAlterEvent $event
      ) {
        $event->getSummary()[] = 'Test';
      },
    ]);

    // Run the procedural hook which should trigger the above handler.
    field_event_dispatcher_field_widget_settings_summary_alter($summary, []);

    /** @var \Drupal\field_event_dispatcher\Event\Field\FieldWidgetSettingsSummaryAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(
      HookEventDispatcherInterface::FIELD_WIDGET_SETTINGS_SUMMARY_ALTER
    );

    $this->assertSame($summary, $event->getSummary());

    $expectedSummary[] = 'Test';

    $this->assertSame($expectedSummary, $summary);
  }

  /**
   * FieldWidgetSettingsSummaryAlterEventTest context test.
   *
   * This tests that the context parameter returns expected values.
   */
  public function testContext() {
    $testFieldDefinition = new BaseFieldDefinition();

    $context = $expectedContext = [
      'widget' => new StringTextfieldWidget(
        'test_widget', [], $testFieldDefinition, [], []
      ),
      'field_definition' => $testFieldDefinition,
      'form_mode' => 'test'
    ];

    $summary = [];

    // Run the procedural hook which should trigger the event.
    field_event_dispatcher_field_widget_settings_summary_alter(
      $summary, $context
    );

    /** @var \Drupal\field_event_dispatcher\Event\Field\FieldWidgetSettingsSummaryAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(
      HookEventDispatcherInterface::FIELD_WIDGET_SETTINGS_SUMMARY_ALTER
    );

    $this->assertSame($expectedContext, $event->getContext());
  }

}
