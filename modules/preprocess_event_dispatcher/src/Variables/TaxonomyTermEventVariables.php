<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

use Drupal\Core\Entity\EntityInterface;
use Drupal\taxonomy\TermInterface;

/**
 * Class TaxonomyTermEventVariables.
 */
class TaxonomyTermEventVariables extends AbstractEntityEventVariables {

  /**
   * Get the TaxonomyTermEntity.
   *
   * @return \Drupal\taxonomy\TermInterface
   *   TaxonomyTermEntity.
   */
  public function getTerm(): TermInterface {
    return $this->variables['term'];
  }

  /**
   * {@inheritdoc}
   */
  public function getEntity(): EntityInterface {
    return $this->getTerm();
  }

}
