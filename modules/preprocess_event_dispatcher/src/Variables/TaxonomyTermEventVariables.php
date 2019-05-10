<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

/**
 * Class TaxonomyTermEventVariables.
 */
class TaxonomyTermEventVariables extends AbstractEntityEventVariables {

  /**
   * Get the TaxonomyTermEntity.
   *
   * @return \Drupal\taxonomy\Entity\Term
   *   TaxonomyTermEntity.
   */
  public function getTerm() {
    return $this->variables['term'];
  }

  /**
   * {@inheritdoc}
   */
  public function getEntity() {
    return $this->getTerm();
  }

}
