<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class EntityPreprocessEvent.
 */
class ContentEntityPreprocessEvent extends AbstractPreprocessEvent implements ComposedPreprocessEventInterface {

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
    /** @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\ContentEntityEventVariables $vars */
    $vars = $this->getVariables();
    return self::name() . '.' . $vars->getEntityType();
  }

}
