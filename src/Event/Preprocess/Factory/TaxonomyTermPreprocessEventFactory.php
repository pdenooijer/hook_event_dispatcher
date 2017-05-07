<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Factory;

use Drupal\hook_event_dispatcher\Event\Preprocess\TaxonomyTermPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\Variables\TaxonomyTermEventVariables;

/**
 * Class TaxonomyTermPreprocessEventFactory.
 *
 * @package Drupal\hook_event_dispatcher\Event\Preprocess\Factory
 */
final class TaxonomyTermPreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Create the PreprocessEvent with EventVariables embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\TaxonomyTermPreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables) {
    return new TaxonomyTermPreprocessEvent(new TaxonomyTermEventVariables($variables));
  }

  /**
   * Get the Event hook name.
   *
   * @return string
   *   The hook name.
   */
  public function getEventHook() {
    return TaxonomyTermPreprocessEvent::getHook();
  }

}
