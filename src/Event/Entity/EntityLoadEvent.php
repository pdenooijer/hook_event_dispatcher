<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class EntityLoadEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Entity
 */
class EntityLoadEvent extends Event implements EventInterface {

  /**
   * The entities.
   *
   * @var array
   */
  protected $entities;
  /**
   * The entity type id.
   *
   * @var string
   */
  protected $entityTypeId;

  /**
   * EntityLoadEvent constructor.
   *
   * @param array $entities
   *   The entities.
   * @param string $entity_type_id
   *   The entity type id.
   */
  public function __construct(array $entities, $entity_type_id) {
    $this->entities = $entities;
    $this->entityTypeId = $entity_type_id;
  }

  /**
   * Get the entities.
   *
   * @return array
   *   The entities.
   */
  public function getEntities() {
    return $this->entities;
  }

  /**
   * Get the entity type id.
   *
   * @return string
   *   The entity type id.
   */
  public function getEntityTypeId() {
    return $this->entityTypeId;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::ENTITY_LOAD;
  }

}
