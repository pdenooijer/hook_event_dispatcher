<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\Core\Entity\EntityInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class BaseEntityEvent
 * @package Drupal\hook_event_dispatcher\Event\Entity
 */
abstract class BaseEntityEvent extends Event implements  EventInterface{

  protected $entity;

  /**
   * BaseEntityEvent constructor.
   * @param \Drupal\Core\Entity\EntityInterface $entity
   */
  public function __construct(EntityInterface $entity) {
    $this->entity = $entity;
  }

  /**
   * @return \Drupal\Core\Entity\EntityInterface
   */
  public function getEntity() {
    return $this->entity;
  }

  /**
   * @param \Drupal\Core\Entity\EntityInterface $entity
   */
  public function setEntity(EntityInterface $entity) {
    $this->entity = $entity;
  }

}