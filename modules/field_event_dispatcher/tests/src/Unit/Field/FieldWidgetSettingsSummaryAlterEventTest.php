<?php

namespace Drupal\Tests\field_event_dispatcher\Unit\Field;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Field\Plugin\Field\FieldWidget\StringTextfieldWidget;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\field_event_dispatcher\Unit\Field\AbstractFieldSettingsSummaryAlterEventTestCase;
use function field_event_dispatcher_field_widget_settings_summary_alter;

/**
 * Class FieldWidgetSettingsSummaryAlterEventTest.
 *
 * @group field_event_dispatcher
 */
class FieldWidgetSettingsSummaryAlterEventTest extends AbstractFieldSettingsSummaryAlterEventTestCase {

  /**
   * {@inheritdoc}
   */
  protected static function getProceduralHookName(): string {
    return 'field_event_dispatcher_field_widget_settings_summary_alter';
  }

  /**
   * {@inheritdoc}
   */
  protected static function getEventName(): string {
    return HookEventDispatcherInterface::FIELD_WIDGET_SETTINGS_SUMMARY_ALTER;
  }

  /**
   * {@inheritdoc}
   */
  protected function getTestContext(BaseFieldDefinition $fieldDefinition): array {
    return [
      'widget' => new StringTextfieldWidget(
        'test_widget', [], $fieldDefinition, [], []
      ),
      'form_mode' => 'test'
    ];
  }

}
