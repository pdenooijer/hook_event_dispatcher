<?php

namespace Drupal\core_event_dispatcher\Event\Entity;

use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\Access\AccessResultNeutral;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class EntityAccessEvent.
 */
class EntityAccessEvent extends AbstractEntityEvent {

  /**
   * The operation that is to be performed on $entity.
   *
   * @var string
   */
  private $operation;
  /**
   * The account trying to access the entity.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  private $account;
  /**
   * The access result.
   *
   * @var \Drupal\Core\Access\AccessResultInterface
   */
  private $accessResult;

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
  public function __construct(EntityInterface $entity, string $operation, AccountInterface $account) {
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
  public function getOperation(): string {
    return $this->operation;
  }

  /**
   * Get the account.
   *
   * @return \Drupal\Core\Session\AccountInterface
   *   The account.
   */
  public function getAccount(): AccountInterface {
    return $this->account;
  }

  /**
   * Get the access result.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function getAccessResult(): AccessResultInterface {
    return $this->accessResult;
  }

  /**
   * Add the access result.
   *
   * @param \Drupal\Core\Access\AccessResultInterface $accessResult
   *   The access result.
   */
  public function addAccessResult(AccessResultInterface $accessResult): void {
    $this->accessResult = $this->accessResult->orIf($accessResult);
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::ENTITY_ACCESS;
  }

}
