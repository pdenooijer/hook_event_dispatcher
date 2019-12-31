<?php

namespace Drupal\media_event_dispatcher\Event\Media;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class MediaSourceInfoAlterEvent.
 */
class MediaSourceInfoAlterEvent extends Event implements EventInterface {

  /**
   * The array of media source plugin definitions, keyed by plugin ID.
   *
   * @var array
   */
  private $sources;

  /**
   * MediaSourceInfoAlterEvent constructor.
   *
   * @param array &$sources
   *   The array of media source plugin definitions, keyed by plugin ID.
   */
  public function __construct(array &$sources) {
    $this->sources = &$sources;
  }

  /**
   * Get the media source plugin definitions.
   *
   * @return array
   *   The array of media source plugin definitions, keyed by plugin ID.
   */
  public function &getSources(): array {
    return $this->sources;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::MEDIA_SOURCE_INFO_ALTER;
  }

}
