<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class EntityViewEvent.
 */
class EntityViewEvent extends BaseEntityEvent {

  /**
   * A renderable array representing the entity content.
   *
   * @var array
   */
  protected $build;
  /**
   * The entity view display.
   *
   * @var \Drupal\Core\Entity\Display\EntityViewDisplayInterface
   */
  protected $display;
  /**
   * The view mode.
   *
   * @var string
   */
  protected $viewMode;

  /**
   * EntityViewEvent constructor.
   *
   * @param array &$build
   *   A renderable array representing the entity content. The module may add
   *   elements to $build prior to rendering. The structure of $build is a
   *   renderable array as expected by drupal_render().
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity object.
   * @param \Drupal\Core\Entity\Display\EntityViewDisplayInterface $display
   *   The entity view display holding the display options configured for the
   *   entity components.
   * @param string $viewMode
   *   The view mode the entity is rendered in.
   */
  public function __construct(array &$build, EntityInterface $entity, EntityViewDisplayInterface $display, $viewMode) {
    parent::__construct($entity);

    $this->build = &$build;
    $this->display = $display;
    $this->viewMode = $viewMode;
  }

  /**
   * Get the build.
   *
   * @return array
   *   The build.
   */
  public function &getBuild() {
    return $this->build;
  }

  /**
   * Set the build.
   *
   * @param array $build
   *   The build.
   *
   * @deprecated This is not needed, this array is past by reference.
   */
  public function setBuild(array $build) {
    $this->build = $build;
  }

  /**
   * Get the display.
   *
   * @return \Drupal\Core\Entity\Display\EntityViewDisplayInterface
   *   The display.
   */
  public function getDisplay() {
    return $this->display;
  }

  /**
   * Get the view mode.
   *
   * @return string
   *   The view mode.
   */
  public function getViewMode() {
    return $this->viewMode;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::ENTITY_VIEW;
  }

}
