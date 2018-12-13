<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess;

/**
 * Class AbstractPreprocessEntityEvent.
 */
abstract class AbstractPreprocessEntityEvent extends AbstractPreprocessEvent implements PreprocessEntityEventInterface {

  /**
   * {@inheritdoc}
   */
  public static function name($bundle = '', $viewMode = '') {
    return \implode('.', \array_filter([parent::name(), $bundle, $viewMode]));
  }

  /**
   * {@inheritdoc}
   */
  public function getVariables() {
    return $this->variables;
  }

}
