<?php

namespace Drupal\field_event_dispatcher\Event\Field;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class FieldWidgetSettingsSummaryAlterEvent.
 */
class FieldWidgetSettingsSummaryAlterEvent extends AbstractFieldSettingsSummaryFormEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::FIELD_WIDGET_SETTINGS_SUMMARY_ALTER;
  }

}
