<?php

namespace Drupal\hook_event_dispatcher\Event\EntityField;

use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\Access\AccessResultNeutral;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class EntityInsertEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\EntityField
 */
class EntityFieldAccessEvent extends Event implements EventInterface {

  /**
   * The operation.
   *
   * @var string
   */
  protected $operation;

  /**
   * The field definition.
   *
   * @var \Drupal\Core\Field\FieldDefinitionInterface
   */
  protected $fieldDefintion;

  /**
   * The account.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $account;

  /**
   * The field item list.
   *
   * @var \Drupal\Core\Field\FieldItemListInterface
   */
  protected $items;

  /**
   * Get the access result.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  protected $accessResult;

  /**
   * EntityFieldAccessEvent constructor.
   *
   * @param string $operation
   *   The operation.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The field definition.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The account interface.
   * @param \Drupal\Core\Field\FieldItemListInterface|null $items
   *   The field item list interface.
   */
  public function __construct(string $operation, FieldDefinitionInterface $fieldDefintion, AccountInterface $account, FieldItemListInterface $items = NULL) {
    $this->operation = $operation;
    $this->fieldDefintion = $fieldDefintion;
    $this->account = $account;
    $this->items = $items;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::ENTITY_FIELD_ACCESS;
  }

  /**
   * Get the access result.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function getAccessResult() {
    return $this->accessResult ? $this->accessResult : AccessResultNeutral::neutral();
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

  /**
   * Get the field definition.
   *
   * @return \Drupal\Core\Field\FieldDefinitionInterface
   *   The field definition.
   */
  public function getFieldDefinition() {
    return $this->fieldDefintion;
  }

}
