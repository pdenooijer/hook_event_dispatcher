<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers;

/**
 * Class EntityMock.
 */
final class EntityMock {

  /**
   * Entity type.
   *
   * @var string
   */
  private $type;

  /**
   * Entity bundle.
   *
   * @var string
   */
  private $bundle;

  /**
   * View mode.
   *
   * @var string
   */
  private $viewMode;

  /**
   * EntityMock constructor.
   *
   * @param string $type
   *   Entity type.
   * @param string $bundle
   *   Entity bundle.
   * @param string $viewMode
   *   View mode.
   */
  public function __construct($type, $bundle, $viewMode) {
    $this->bundle = $bundle;
    $this->type = $type;
    $this->viewMode = $viewMode;
  }

  /**
   * Get the entity type.
   *
   * @return string
   *   Type.
   */
  public function getEntityType() {
    return $this->type;
  }

  /**
   * Get the entity bundle.
   *
   * @return string
   *   Bundle.
   */
  public function bundle() {
    return $this->bundle;
  }

  /**
   * Get the view mode.
   *
   * @return string
   *   ViewMode.
   */
  public function getViewMode() {
    return $this->viewMode;
  }

}
