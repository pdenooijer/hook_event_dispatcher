<?php

namespace Drupal\Tests\field_event_dispatcher\Unit\Field;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\BasicStringFormatter;
use Drupal\field_event_dispatcher\Event\Field\FieldFormatterSettingsSummaryAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;
use function field_event_dispatcher_field_formatter_settings_summary_alter;

/**
 * Class FieldFormatterSettingsSummaryAlterEventTest.
 *
 * @group field_event_dispatcher
 */
class FieldFormatterSettingsSummaryAlterEventTest extends UnitTestCase {

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
   * FieldFormatterSettingsSummaryAlterEventTest adding summary test.
   *
   * This tests adding an additional summary.
   */
  public function testAddSummary() {
    $summary = $expectedSummary = [];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::FIELD_FORMATTER_SETTINGS_SUMMARY_ALTER => static function (
        FieldFormatterSettingsSummaryAlterEvent $event
      ) {
        $event->getSummary()[] = 'Test';
      },
    ]);

    // Run the procedural hook which should trigger the above handler.
    field_event_dispatcher_field_formatter_settings_summary_alter($summary, []);

    /** @var \Drupal\field_event_dispatcher\Event\Field\FieldFormatterSettingsSummaryAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(
      HookEventDispatcherInterface::FIELD_FORMATTER_SETTINGS_SUMMARY_ALTER
    );

    $this->assertSame($summary, $event->getSummary());

    $expectedSummary[] = 'Test';

    $this->assertSame($expectedSummary, $summary);
  }

  /**
   * FieldFormatterSettingsSummaryAlterEventTest context test.
   *
   * This tests that the context parameter returns expected values.
   */
  public function testContext() {
    $testFieldDefinition = new BaseFieldDefinition();

    $context = $expectedContext = [
      'formatter' => new BasicStringFormatter(
        'test_formatter', [], $testFieldDefinition, [], 'label', 'view_mode', []
      ),
      'field_definition' => $testFieldDefinition,
      'view_mode' => 'test'
    ];

    $summary = [];

    // Run the procedural hook which should trigger the event.
    field_event_dispatcher_field_formatter_settings_summary_alter(
      $summary, $context
    );

    /** @var \Drupal\field_event_dispatcher\Event\Field\FieldFormatterSettingsSummaryAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(
      HookEventDispatcherInterface::FIELD_FORMATTER_SETTINGS_SUMMARY_ALTER
    );

    $this->assertSame($expectedContext, $event->getContext());
  }

}
