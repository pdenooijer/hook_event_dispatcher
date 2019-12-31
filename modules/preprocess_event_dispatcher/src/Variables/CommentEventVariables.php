<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

use Drupal\comment\CommentInterface;
use Drupal\Core\Entity\EntityInterface;

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
  public function getComment(): CommentInterface {
    return $this->variables['comment'];
  }

  /**
   * {@inheritdoc}
   */
  public function getEntity(): EntityInterface {
    return $this->getComment();
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityType(): string {
    return 'comment';
  }

  /**
   * Get commented entity.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *   Commented entity.
   */
  public function getCommentedEntity(): EntityInterface {
    return $this->variables['commented_entity'];
  }

}
