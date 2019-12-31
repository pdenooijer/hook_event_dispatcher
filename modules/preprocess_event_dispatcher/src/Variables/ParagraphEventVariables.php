<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

use Drupal\Core\Entity\EntityInterface;
use Drupal\paragraphs\ParagraphInterface;

/**
 * Class ParagraphEventVariables.
 */
class ParagraphEventVariables extends AbstractEntityEventVariables {

  /**
   * Get the paragraph object.
   *
   * @return \Drupal\paragraphs\ParagraphInterface
   *   Return the paragraph object.
   */
  public function getParagraph(): ParagraphInterface {
    return $this->variables['paragraph'];
  }

  /**
   * Get the Entity.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *   EckEntity.
   */
  public function getEntity(): EntityInterface {
    return $this->getParagraph();
  }

}
