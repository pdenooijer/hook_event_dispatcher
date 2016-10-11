<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;

/**
 * Class EntityViewEvent
 * @package Drupal\hook_event_dispatcher\Event\Entity
 */
class EntityViewEvent extends BaseEntityEvent {

  protected $build;
  protected $display;
  protected $viewMode;

  /**
   * EntityViewEvent constructor.
   * @param array $build
   * @param \Drupal\Core\Entity\EntityInterface $entity
   * @param \Drupal\Core\Entity\Display\EntityViewDisplayInterface $display
   * @param $view_mode
   */
  public function __construct(array &$build, EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode) {
    parent::__construct($entity);

    $this->build = $build;
    $this->display = $display;
    $this->viewMode = $view_mode;
  }

  /**
   * @return array
   */
  public function getBuild() {
    return $this->build;
  }

  /**
   * @param array $build
   */
  public function setBuild($build) {
    $this->build = $build;
  }

  /**
   * @return \Drupal\Core\Entity\Display\EntityViewDisplayInterface
   */
  public function getDisplay() {
    return $this->display;
  }

  /**
   * @return mixed
   */
  public function getViewMode() {
    return $this->viewMode;
  }

  /**
   * @inheritdoc.
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::ENTITY_VIEW;
  }
}