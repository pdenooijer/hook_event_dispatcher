<?php

namespace Drupal\hook_event_dispatcher\Event\Preprocess\Variables;

/**
 * Class CommentEventVariables.
 */
class CommentEventVariables extends AbstractEntityEventVariables {

  /**
   * Get the comment.
   *
   * @return \Drupal\comment\Entity\Comment
   *   The comment.
   */
  public function getComment() {
    return $this->variables['comment'];
  }

  /**
   * {@inheritdoc}
   */
  public function getEntity() {
    return $this->getComment();
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityType() {
    return 'comment';
  }

  /**
   * Get commented entity.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *   Commented entity.
   */
  public function getCommentedEntity() {
    return $this->variables['commented_entity'];
  }

}
