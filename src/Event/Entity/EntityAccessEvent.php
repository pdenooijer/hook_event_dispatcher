<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\Access\AccessResultNeutral;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class EntityAccessEvent.
 */
class EntityAccessEvent extends BaseEntityEvent {

  /**
   * The operation that is to be performed on $entity.
   *
   * @var string
   */
  protected $operation;
  /**
   * The account trying to access the entity.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $account;
  /**
   * The access result.
   *
   * @var \Drupal\Core\Access\AccessResultInterface
   */
  protected $accessResult;

  /**
   * EntityAccessEvent constructor.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity to check access to.
   * @param string $operation
   *   The operation that is to be performed on $entity.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The account trying to access the entity.
   */
  public function __construct(EntityInterface $entity, $operation, AccountInterface $account) {
    parent::__construct($entity);

    $this->operation = $operation;
    $this->account = $account;
    $this->accessResult = new AccessResultNeutral();
  }

  /**
   * Get the operation.
   *
   * @return string
   *   The Operation.
   */
  public function getOperation() {
    return $this->operation;
  }

  /**
   * Get the account.
   *
   * @return \Drupal\Core\Session\AccountInterface
   *   The account.
   */
  public function getAccount() {
    return $this->account;
  }

  /**
   * Get the access result.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function getAccessResult() {
    return $this->accessResult;
  }

  /**
   * Set the access result.
   *
   * @param \Drupal\Core\Access\AccessResultInterface $accessResult
   *   The access result.
   *
   * @deprecated in favour of addAccessResult() which is more descriptive.
   */
  public function setAccessResult(AccessResultInterface $accessResult) {
    $this->addAccessResult($accessResult);
  }

  /**
   * Add the access result.
   *
   * @param \Drupal\Core\Access\AccessResultInterface $accessResult
   *   The access result.
   */
  public function addAccessResult(AccessResultInterface $accessResult) {
    $this->accessResult = $this->accessResult->orIf($accessResult);
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::ENTITY_ACCESS;
  }

}
