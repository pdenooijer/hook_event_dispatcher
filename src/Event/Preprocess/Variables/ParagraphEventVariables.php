<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class PageEventVariables.
 */
class ParagraphEventVariables extends AbstractEventVariables {

  /**
   * Get the paragraph object.
   *
   * @return \Drupal\paragraphs\Entity\Paragraph
   *   Return the paragraph object.
   */
  public function getParagraph() {
    return $this->variables['paragraph'];
  }

}
