<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class EntityLoadEvent
 * @package Drupal\hook_event_dispatcher\Event\Entity
 */
class EntityLoadEvent extends Event implements EventInterface {

  protected $entities;
  protected $entityTypeId;

  /**
   * EntityLoadEvent constructor.
   * @param array $entities
   * @param $entity_type_id
   */
  public function __construct(array $entities, $entity_type_id) {
    $this->entities = $entities;
    $this->entityType = $entity_type_id;
  }

  /**
   * @return array
   */
  public function getEntities() {
    return $this->entities;
  }

  /**
   * @return mixed
   */
  public function getEntityTypeId() {
    return $this->entityTypeId;
  }

  /**
   * @inheritdoc.
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::ENTITY_LOAD;
  }
}