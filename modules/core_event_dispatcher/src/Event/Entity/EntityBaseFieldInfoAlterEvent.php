<?php

namespace Drupal\core_event_dispatcher\Event\Entity;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class EntityBaseFieldInfoAlterEvent.
 */
class EntityBaseFieldInfoAlterEvent extends Event implements EventInterface {

  /**
   * Field info.
   *
   * @var array
   */
  private $fields;
  /**
   * The entity type.
   *
   * @var \Drupal\Core\Entity\EntityTypeInterface
   */
  private $entityType;

  /**
   * EntityExtraFieldInfoAlterEvent constructor.
   *
   * @param array $fields
   *   Extra field info.
   * @param \Drupal\Core\Entity\EntityTypeInterface $entityType
   *   The entity type.
   */
  public function __construct(array &$fields, EntityTypeInterface $entityType) {
    $this->entityType = $entityType;
    $this->fields = &$fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::ENTITY_BASE_FIELD_INFO_ALTER;
  }

  /**
   * Get the field info.
   *
   * @return array
   *   Extra field info.
   */
  public function &getFields(): array {
    return $this->fields;
  }

  /**
   * Get the entity type.
   *
   * @return \Drupal\Core\Entity\EntityTypeInterface
   *   The entity type.
   */
  public function getEntityType(): EntityTypeInterface {
    return $this->entityType;
  }

}
