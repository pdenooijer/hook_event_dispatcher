<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class CommentEventVariables.
 */
class CommentEventVariables extends AbstractEventVariables {

  /**
   * Get the comment.
   *
   * @return \Drupal\comment\Entity\Comment
   *   The comment.
   */
  public function getComment() {
    return $this->variables['comment'];
  }

}
