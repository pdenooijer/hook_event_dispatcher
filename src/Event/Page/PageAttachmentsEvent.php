<?php

namespace Drupal\hook_event_dispatcher\Event\Page;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class PageAttachmentsEvent.
 */
class PageAttachmentsEvent extends Event implements EventInterface {

  /**
   * The attachments array.
   *
   * @var array
   */
  private $attachments;

  /**
   * PageAttachmentsEvent constructor.
   *
   * @param array $attachments
   *   The attachments array.
   */
  public function __construct(array &$attachments) {
    $this->attachments = &$attachments;
  }

  /**
   * Get the attachments array.
   *
   * @return array
   *   The attachments array.
   */
  public function &getAttachments() {
    return $this->attachments;
  }

  /**
   * Set the attachments.
   *
   * @param array $attachments
   *   The attachments array.
   */
  public function setAttachments(array $attachments) {
    $this->attachments = $attachments;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::PAGE_ATTACHMENTS;
  }

}
