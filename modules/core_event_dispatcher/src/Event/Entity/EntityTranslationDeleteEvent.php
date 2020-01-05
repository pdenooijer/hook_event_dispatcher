<?php

namespace Drupal\core_event_dispatcher\Event\Entity;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class EntityTranslationDeleteEvent.
 */
class EntityTranslationDeleteEvent extends AbstractEntityEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::ENTITY_TRANSLATION_DELETE;
  }

}
