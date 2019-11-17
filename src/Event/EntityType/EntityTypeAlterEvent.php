<?php

namespace Drupal\hook_event_dispatcher\Event\EntityType;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class EntityTypeBuildEvent.
 */
class EntityTypeAlterEvent extends Event implements EventInterface {

  /**
   * Field info.
   *
   * @var array
   */
  private $entityTypes;

  /**
   * EntityTypeBuildEvent constructor.
   *
   * @param array $entityTypes
   *   Extra types info.
   */
  public function __construct(array &$entityTypes) {
    $this->entityTypes = &$entityTypes;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::ENTITY_TYPE_ALTER;
  }

  /**
   * Get the entity types.
   *
   * @return \Drupal\Core\Entity\EntityTypeInterface[]
   *   Entity types info.
   */
  public function &getEntityTypes() {
    return $this->entityTypes;
  }

}
