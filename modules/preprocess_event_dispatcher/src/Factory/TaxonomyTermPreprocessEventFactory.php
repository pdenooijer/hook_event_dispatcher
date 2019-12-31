<?php

namespace Drupal\preprocess_event_dispatcher\Factory;

use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\TaxonomyTermPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Variables\TaxonomyTermEventVariables;

/**
 * Class TaxonomyTermPreprocessEventFactory.
 */
final class TaxonomyTermPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createEvent(array &$variables): AbstractPreprocessEvent {
    return new TaxonomyTermPreprocessEvent(new TaxonomyTermEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook(): string {
    return TaxonomyTermPreprocessEvent::getHook();
  }

}
