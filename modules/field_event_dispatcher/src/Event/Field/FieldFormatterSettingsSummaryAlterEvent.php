<?php

namespace Drupal\field_event_dispatcher\Event\Field;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\field_event_dispatcher\Event\Field\AbstractFieldSettingsSummaryFormEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class FieldFormatterSettingsSummaryAlterEvent.
 */
class FieldFormatterSettingsSummaryAlterEvent extends AbstractFieldSettingsSummaryFormEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::FIELD_FORMATTER_SETTINGS_SUMMARY_ALTER;
  }

}
