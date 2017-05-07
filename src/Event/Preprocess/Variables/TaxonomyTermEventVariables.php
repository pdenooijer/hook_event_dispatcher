<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class TaxonomyTermEventVariables.
 *
 * @package Drupal\preprocess_event\Variables
 */
class TaxonomyTermEventVariables extends AbstractEventVariables {

  /**
   * Get the TaxonomyTermEntity.
   *
   * @return \Drupal\taxonomy\Entity\Term
   *   TaxonomyTermEntity.
   */
  public function getEntity() {
    return $this->variables['term'];
  }

}
