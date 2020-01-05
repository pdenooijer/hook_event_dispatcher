<?php

namespace Drupal\core_event_dispatcher\Event\Entity;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class EntityBaseFieldInfoEvent.
 */
class EntityBaseFieldInfoEvent extends Event implements EventInterface {

  /**
   * The entity type.
   *
   * @var \Drupal\Core\Entity\EntityTypeInterface
   */
  private $entityType;
  /**
   * The fields.
   *
   * @var array
   */
  private $fields = [];

  /**
   * EntityBaseFieldInfoEvent constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entityType
   *   The entity type.
   */
  public function __construct(EntityTypeInterface $entityType) {
    $this->entityType = $entityType;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::ENTITY_BASE_FIELD_INFO;
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

  /**
   * Get the fields.
   *
   * @return array
   *   The fields.
   */
  public function getFields(): array {
    return $this->fields;
  }

  /**
   * Set the fields.
   *
   * @param array $fields
   *   The fields.
   */
  public function setFields(array $fields): void {
    $this->fields = $fields;
  }

}
