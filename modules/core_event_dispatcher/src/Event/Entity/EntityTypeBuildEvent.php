<?php

namespace Drupal\core_event_dispatcher\Event\Entity;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class EntityTypeBuildEvent.
 */
class EntityTypeBuildEvent extends Event implements EventInterface {

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
   *   Extra field info.
   */
  public function __construct(array &$entityTypes) {
    $this->entityTypes = &$entityTypes;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::ENTITY_TYPE_BUILD;
  }

  /**
   * Get the entity types.
   *
   * @return \Drupal\Core\Entity\EntityTypeInterface[]
   *   Entity types info.
   */
  public function &getEntityTypes(): array {
    return $this->entityTypes;
  }

}
