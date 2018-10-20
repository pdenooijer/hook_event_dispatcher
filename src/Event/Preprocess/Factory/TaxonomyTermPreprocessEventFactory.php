<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\TaxonomyTermPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\TaxonomyTermEventVariables;

/**
 * Class TaxonomyTermPreprocessEventFactory.
 */
final class TaxonomyTermPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables) {
    return new TaxonomyTermPreprocessEvent(new TaxonomyTermEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook() {
    return TaxonomyTermPreprocessEvent::getHook();
  }

}
