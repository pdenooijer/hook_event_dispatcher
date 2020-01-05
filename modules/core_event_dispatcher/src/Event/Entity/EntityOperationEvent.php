<?php

namespace Drupal\core_event_dispatcher\Event\Entity;

use Drupal\Core\Entity\EntityInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class EntityLoadEvent.
 */
class EntityOperationEvent extends Event implements EventInterface {

  /**
   * The operations.
   *
   * @var array
   */
  private $operations = [];

  /**
   * The entity.
   *
   * @var \Drupal\Core\Entity\EntityInterface
   */
  private $entity;

  /**
   * EntityOperationEvent constructor.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity.
   */
  public function __construct(EntityInterface $entity) {
    $this->entity = $entity;
  }

  /**
   * Get the entity.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *   The entity.
   */
  public function getEntity(): EntityInterface {
    return $this->entity;
  }

  /**
   * Get the operations.
   *
   * @return array
   *   The operations.
   */
  public function getOperations(): array {
    return $this->operations;
  }

  /**
   * Set the operations.
   *
   * @param array $operations
   *   An array of operations.
   */
  public function setOperations(array $operations): void {
    $this->operations = $operations;
  }

  /**
   * Add an operation.
   *
   * @param string $name
   *   Operation name.
   * @param array $operation
   *   Operation definition.
   */
  public function addOperation(string $name, array $operation): void {
    $this->operations[$name] = $operation;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::ENTITY_OPERATION;
  }

}
