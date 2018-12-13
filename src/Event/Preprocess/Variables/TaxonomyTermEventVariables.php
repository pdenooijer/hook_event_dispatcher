<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

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
