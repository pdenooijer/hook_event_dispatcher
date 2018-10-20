<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\Core\Entity\EntityInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class BaseEntityEvent.
 */
abstract class BaseEntityEvent extends Event implements EventInterface {

  /**
   * The Entity.
   *
   * @var \Drupal\Core\Entity\EntityInterface
   */
  protected $entity;

  /**
   * BaseEntityEvent constructor.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The Entity.
   */
  public function __construct(EntityInterface $entity) {
    $this->entity = $entity;
  }

  /**
   * Get the Entity.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *   The Entity.
   */
  public function getEntity() {
    return $this->entity;
  }

  /**
   * Set the Entity.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The Entity.
   *
   * @deprecated This is not needed, objects are past by reference.
   */
  public function setEntity(EntityInterface $entity) {
    $this->entity = $entity;
  }

}
