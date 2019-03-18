<?php

namespace Drupal\hook_event_dispatcher\Event\Entity;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class EntityTranslationDeleteEvent.
 */
class EntityTranslationDeleteEvent extends BaseEntityEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::ENTITY_TRANSLATION_DELETE;
  }

}
