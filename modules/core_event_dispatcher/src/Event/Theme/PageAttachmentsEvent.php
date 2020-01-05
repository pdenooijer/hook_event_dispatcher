<?php

namespace Drupal\core_event_dispatcher\Event\Theme;

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
  public function &getAttachments(): array {
    return $this->attachments;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::PAGE_ATTACHMENTS;
  }

}
