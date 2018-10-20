<?php

namespace Drupal\hook_event_dispatcher\Event\EntityField;

use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\Access\AccessResultNeutral;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class EntityInsertEvent.
 */
class EntityFieldAccessEvent extends Event implements EventInterface {

  /**
   * The operation.
   *
   * @var string
   */
  private $operation;

  /**
   * The field definition.
   *
   * @var \Drupal\Core\Field\FieldDefinitionInterface
   */
  private $fieldDefinition;

  /**
   * The account.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  private $account;

  /**
   * The field item list.
   *
   * @var \Drupal\Core\Field\FieldItemListInterface
   */
  private $items;

  /**
   * Get the access result.
   *
   * @var \Drupal\Core\Access\AccessResultInterface
   */
  private $accessResult;

  /**
   * EntityFieldAccessEvent constructor.
   *
   * @param string $operation
   *   The operation.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $fieldDefinition
   *   The field definition.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The account interface.
   * @param \Drupal\Core\Field\FieldItemListInterface|null $items
   *   The field item list interface.
   */
  public function __construct($operation, FieldDefinitionInterface $fieldDefinition, AccountInterface $account, FieldItemListInterface $items = NULL) {
    $this->operation = $operation;
    $this->fieldDefinition = $fieldDefinition;
    $this->account = $account;
    $this->items = $items;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::ENTITY_FIELD_ACCESS;
  }

  /**
   * Get the operation.
   *
   * @return string
   *   The operation.
   */
  public function getOperation() {
    return $this->operation;
  }

  /**
   * Get the field definition.
   *
   * @return \Drupal\Core\Field\FieldDefinitionInterface
   *   The field definition.
   */
  public function getFieldDefinition() {
    return $this->fieldDefinition;
  }

  /**
   * Get the account interface.
   *
   * @return \Drupal\Core\Session\AccountInterface
   *   Account interface.
   */
  public function getAccount() {
    return $this->account;
  }

  /**
   * Get the items.
   *
   * @return \Drupal\Core\Field\FieldItemListInterface
   *   The items.
   */
  public function getItems() {
    return $this->items;
  }

  /**
   * Get the access result.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function getAccessResult() {
    return $this->accessResult ?: AccessResultNeutral::neutral();
  }

  /**
   * Set the access result.
   *
   * @param \Drupal\Core\Access\AccessResultInterface $accessResult
   *   The access result.
   */
  public function setAccessResult(AccessResultInterface $accessResult) {
    $this->accessResult = $accessResult;
  }

}
