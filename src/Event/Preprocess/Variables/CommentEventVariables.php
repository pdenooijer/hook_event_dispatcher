<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class CommentEventVariables.
 *
 * @package Drupal\hook_event_dispatcher
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
