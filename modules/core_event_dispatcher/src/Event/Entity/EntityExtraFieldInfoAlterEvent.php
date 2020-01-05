<?php

namespace Drupal\core_event_dispatcher\Event\Entity;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class EntityExtraFieldInfoAlterEvent.
 */
class EntityExtraFieldInfoAlterEvent extends Event implements EventInterface {

  /**
   * Field info.
   *
   * @var array
   */
  private $fieldInfo;

  /**
   * EntityExtraFieldInfoAlterEvent constructor.
   *
   * @param array $fieldInfo
   *   Extra field info.
   */
  public function __construct(array &$fieldInfo) {
    $this->fieldInfo = &$fieldInfo;
  }

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::ENTITY_EXTRA_FIELD_INFO_ALTER;
  }

  /**
   * Get the field info.
   *
   * @return array
   *   Extra field info.
   */
  public function &getFieldInfo(): array {
    return $this->fieldInfo;
  }

}
