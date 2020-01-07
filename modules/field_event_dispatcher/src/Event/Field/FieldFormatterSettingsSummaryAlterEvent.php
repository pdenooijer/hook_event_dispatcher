<?php

namespace Drupal\field_event_dispatcher\Event\Field;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class FieldFormatterSettingsSummaryAlterEvent.
 */
class FieldFormatterSettingsSummaryAlterEvent extends Event implements EventInterface {

  /**
   * An array of summary messages.
   *
   * @var array
   */
  private $summary;

  /**
   * An associative array containing related context for this formatter.
   *
   * @var array
   */
  private $context;

  /**
   * FieldFormatterSettingsSummaryAlterEvent constructor.
   *
   * @param array &$summary
   *   An array of summary messages.
   * @param array $context
   *   An associative array with the following elements:
   *   - formatter: The formatter plugin.
   *   - field_definition: The field definition.
   *   - view_mode: The view mode being configured.
   */
  public function __construct(array &$summary, array $context) {
    $this->summary = &$summary;
    $this->context = $context;
  }

  /**
   * Get the existing array of summary messages.
   *
   * @return array
   *   An array of summary messages.
   */
  public function &getSummary(): array {
    return $this->summary;
  }

  /**
   * Get the associative array containing related context for this formatter.
   *
   * @return array
   *   An associative array of context for this field formatter instance.
   */
  public function getContext(): array {
    return $this->context;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::FIELD_FORMATTER_SETTINGS_SUMMARY_ALTER;
  }

}
