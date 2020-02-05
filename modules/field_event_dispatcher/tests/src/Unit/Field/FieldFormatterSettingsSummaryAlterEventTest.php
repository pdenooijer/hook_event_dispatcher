<?php

namespace Drupal\Tests\field_event_dispatcher\Unit\Field;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\BasicStringFormatter;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\field_event_dispatcher\Unit\Field\AbstractFieldSettingsSummaryAlterEventTestCase;
use function field_event_dispatcher_field_formatter_settings_summary_alter;

/**
 * Class FieldFormatterSettingsSummaryAlterEventTest.
 *
 * @group field_event_dispatcher
 */
class FieldFormatterSettingsSummaryAlterEventTest extends AbstractFieldSettingsSummaryAlterEventTestCase {

  /**
   * {@inheritdoc}
   */
  protected static function getProceduralHookName(): string {
    return 'field_event_dispatcher_field_formatter_settings_summary_alter';
  }

  /**
   * {@inheritdoc}
   */
  protected static function getEventName(): string {
    return HookEventDispatcherInterface::FIELD_FORMATTER_SETTINGS_SUMMARY_ALTER;
  }

  /**
   * {@inheritdoc}
   */
  protected function getTestContext(BaseFieldDefinition $fieldDefinition): array {
    return [
      'formatter' => new BasicStringFormatter(
        'test_formatter', [], $fieldDefinition, [], 'label', 'view_mode', []
      ),
      'view_mode' => 'test'
    ];
  }

}
