<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;

/**
 * Class EntityAccessEvent
 * @package Drupal\hook_event_dispatcher\Event\Entity
 */
class EntityAccessEvent extends BaseEntityEvent {

  protected $operation;
  protected $account;
  protected $accessResult;

  /**
   * EntityAccessEvent constructor.
   * @param \Drupal\Core\Entity\EntityInterface $entity
   * @param $operation
   * @param \Drupal\Core\Session\AccountInterface $account
   */
  public function __construct(EntityInterface $entity, $operation, AccountInterface $account) {
    parent::__construct($entity);

    $this->operation = $operation;
    $this->account = $account;
  }

  /**
   * @return mixed
   */
  public function getOperation() {
    return $this->operation;
  }

  /**
   * @return \Drupal\Core\Session\AccountInterface
   */
  public function getAccount() {
    return $this->account;
  }

  /**
   * @return \Drupal\Core\Access\AccessResultInterface
   */
  public function getAccessResult() {
    return $this->accessResult;
  }

  /**
   * @param \Drupal\Core\Access\AccessResultInterface $accessResult
   */
  public function setAccessResult(AccessResultInterface $accessResult) {
    $this->accessResult = $accessResult;
  }

  /**
   * @inheritdoc.
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::ENTITY_ACCESS;
  }
}