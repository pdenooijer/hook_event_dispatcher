<?php

namespace Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers;

use Drupal\Core\Entity\EntityInterface;
use Mockery;

/**
 * Class EntityMock.
 */
final class EntityMockFactory {

  /**
   * Get a full Entity mock.
   *
   * @param string $class
   *   Class of mocked entity.
   * @param string $type
   *   Entity type.
   * @param string $bundle
   *   Entity bundle.
   * @param string $viewMode
   *   View mode.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *   EntityMock.
   */
  public static function getMock(string $class, string $type, string $bundle, string $viewMode): EntityInterface {
    return Mockery::mock(
      $class,
      EntityInterface::class,
      [
        'getEntityType' => $type,
        'bundle' => $bundle,
        'getViewMode' => $viewMode,
      ]
    );
  }

}
