<?php

namespace Drupal\field_event_dispatcher\Event\Field;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class FieldFormatterInfoAlterEvent.
 */
class FieldFormatterInfoAlterEvent extends Event implements EventInterface {

  /**
   * An array of information on existing field formatter types.
   *
   * @var array
   */
  private $info;

  /**
   * FieldFormatterInfoAlterEvent constructor.
   *
   * @param array &$info
   *   An array of information on existing field formatter types.
   */
  public function __construct(array &$info) {
    $this->info = &$info;
  }

  /**
   * Get the existing field formatter type definitions.
   *
   * @return array
   *   An array of information on existing field formatter types.
   */
  public function &getInfo(): array {
    return $this->info;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::FIELD_FORMATTER_INFO_ALTER;
  }

}
