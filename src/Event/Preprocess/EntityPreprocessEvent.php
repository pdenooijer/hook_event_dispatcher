<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class EntityPreprocessEvent.
 */
final class EntityPreprocessEvent extends AbstractPreprocessEvent {

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public static function getHook() {
    return 'entity';
  }

  /**
   * Get the hook name.
   *
   * @return string
   *   Hook name.
   */
  public function getComposedName() {
    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\EntityEventVariables $vars */
    $vars = $this->getVariables();
    return self::name() . '.' . $vars->getEntityType();
  }

}
