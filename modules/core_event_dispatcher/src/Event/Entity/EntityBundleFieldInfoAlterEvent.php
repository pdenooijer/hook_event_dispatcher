<?php

namespace Drupal\core_event_dispatcher\Event\Entity;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class EntityBundleFieldInfoAlterEvent.
 */
class EntityBundleFieldInfoAlterEvent extends Event implements EventInterface {

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
   * The bundle name.
   *
   * @var string
   */
  private $bundle;

  /**
   * EntityExtraFieldInfoAlterEvent constructor.
   *
   * @param array $fields
   *   Extra field info.
   * @param \Drupal\Core\Entity\EntityTypeInterface $entityType
   *   The entity type.
   * @param string $bundle
   *   The bundle name.
   */
  public function __construct(array &$fields, EntityTypeInterface $entityType, string $bundle) {
    $this->fields = &$fields;
    $this->entityType = $entityType;
    $this->bundle = $bundle;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::ENTITY_BUNDLE_FIELD_INFO_ALTER;
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
   * Get the EntityType.
   *
   * @return \Drupal\Core\Entity\EntityTypeInterface
   *   The EntityType.
   */
  public function getEntityType(): EntityTypeInterface {
    return $this->entityType;
  }

  /**
   * Gets the Bundle.
   *
   * @return string
   *   The Bundle.
   */
  public function getBundle(): string {
    return $this->bundle;
  }

}
