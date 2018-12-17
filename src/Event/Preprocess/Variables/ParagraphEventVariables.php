<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class ParagraphEventVariables.
 */
class ParagraphEventVariables extends AbstractEntityEventVariables {

  /**
   * Get the paragraph object.
   *
   * @return \Drupal\paragraphs\Entity\Paragraph
   *   Return the paragraph object.
   */
  public function getParagraph() {
    return $this->variables['paragraph'];
  }

  /**
   * Get the Entity.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *   EckEntity.
   */
  public function getEntity() {
    return $this->getParagraph();
  }

}
