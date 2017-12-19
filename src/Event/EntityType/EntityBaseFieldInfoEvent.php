<?php

namespace Drupal\hook_event_dispatcher\Event\EntityType;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class EntityBaseFieldInfoEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\EntityType
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
   * @var static[]
   */
  private $fields = [];

  public function __construct(EntityTypeInterface $entityType) {
    $this->entityType = $entityType;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::ENTITY_BASE_FIELD_INFO;
  }

  /**
   * Get the entity type.
   *
   * @return \Drupal\Core\Entity\EntityTypeInterface
   *   The entity type.
   */
  public function getEntityType() {
    return $this->entityType;
  }

  /**
   * Get the fields.
   *
   * @return static[]
   *   The fields.
   */
  public function getFields() {
    return $this->fields;
  }

  /**
   * Set the fields.
   *
   * @param static[] $fields
   *   The fields.
   */
  public function setFields($fields) {
    $this->fields = $fields;
  }

}
