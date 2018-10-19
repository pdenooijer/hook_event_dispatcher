<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class TaxonomyTermEventVariables.
 */
class TaxonomyTermEventVariables extends ContentEntityEventVariables {

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
