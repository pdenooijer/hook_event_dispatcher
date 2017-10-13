<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class PageEventVariables.
 */
class ParagraphEventVariables extends AbstractEventVariables {

  /**
   * @return \Drupal\paragraphs\Entity\Paragraph
   */
  public function getParagraph() {
    return $this->variables['paragraph'];
  }
  
}
