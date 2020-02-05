<?php

namespace Drupal\field_event_dispatcher\Event\Field;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AbstractFieldSettingsSummaryFormEvent.
 */
abstract class AbstractFieldSettingsSummaryFormEvent extends Event implements EventInterface {

  /**
   * An array of summary messages.
   *
   * @var array
   */
  private $summary;

  /**
   * An associative array containing related context for this formatter/widget.
   *
   * @var array
   */
  private $context;

  /**
   * AbstractFieldSettingsSummaryFormEvent constructor.
   *
   * @param array &$summary
   *   An array of summary messages.
   * @param array $context
   *   An associative array with the following elements:
   *   - field_definition: The field definition.
   *   If this is a field formatter, will also contain:
   *   - formatter: The formatter plugin.
   *   - view_mode: The view mode being configured.
   *   If this is a field widget, will also contain:
   *   - widget: The widget object.
   *   - form_mode: The form mode being configured.
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
   * Get the associative array containing context for this formatter/widget.
   *
   * @return array
   *   An associative array of context for this field formatter/widget instance.
   */
  public function getContext(): array {
    return $this->context;
  }

}
