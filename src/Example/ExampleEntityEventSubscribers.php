<?php

namespace Drupal\hook_event_dispatcher\Example;

use Drupal\hook_event_dispatcher\Event\Entity\EntityDeleteEvent;
use Drupal\hook_event_dispatcher\Event\Entity\EntityInsertEvent;
use Drupal\hook_event_dispatcher\Event\Entity\EntityPredeleteEvent;
use Drupal\hook_event_dispatcher\Event\Entity\EntityPresaveEvent;
use Drupal\hook_event_dispatcher\Event\Entity\EntityUpdateEvent;
use Drupal\hook_event_dispatcher\Event\Entity\EntityViewEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;
use Drupal\node\NodeInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExampleEntityEventSubscribers.
 *
 * Don't forget to define your class as a service and tag it as
 * an "event_subscriber":
 *
 * services:
 *   hook_event_dispatcher.example_entity_subscribers:
 *   class:'\Drupal\hook_event_dispatcher\Example\ExampleEntityEventSubscribers'
 *   tags:
 *     - { name: 'event_subscriber' }
 *
 * @package Drupal\hook_event_dispatcher\Example
 */
class ExampleEntityEventSubscribers implements EventSubscriberInterface {

  /**
   * Alter entity view.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Entity\EntityViewEvent $event
   *   The event.
   */
  public function alterEntityView(EntityViewEvent $event) {
    $entity = $event->getEntity();

    // Only do this for entities of type Node.
    if ($entity instanceof NodeInterface) {
      $build = &$event->getBuild();
      $build['extra_markup'] = [
        '#markup' => 'this is extra markup',
      ];
    }
  }

  /**
   * Entity pre save.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Entity\EntityPresaveEvent $event
   *   The event.
   */
  public function entityPreSave(EntityPresaveEvent $event) {
    $entity = $event->getEntity();
    $entity->title->value = 'Overwritten';
  }

  /**
   * Entity insert.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Entity\EntityInsertEvent $event
   *   The event.
   */
  public function entityInsert(EntityInsertEvent $event) {
    $entity = $event->getEntity();
    // Do some fancy stuff.
    fancy_stuff($entity);
  }

  /**
   * Entity update.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Entity\EntityUpdateEvent $event
   *   The event.
   */
  public function entityUpdate(EntityUpdateEvent $event) {
    $entity = $event->getEntity();
    // Do some fancy stuff.
    fancy_stuff($entity);
  }

  /**
   * Entity pre delete.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Entity\EntityPredeleteEvent $event
   *   The event.
   */
  public function entityPreDelete(EntityPredeleteEvent $event) {
    $entity = $event->getEntity();
    // Do something before entity is deleted.
    fancy_stuff($entity);
  }

  /**
   * Entity delete.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Entity\EntityDeleteEvent $event
   *   The event.
   */
  public function entityDelete(EntityDeleteEvent $event) {
    $entity = $event->getEntity();
    // Do some fancy stuff.
    fancy_stuff($entity);
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      HookEventDispatcherEvents::ENTITY_VIEW => 'alterEntityView',
      HookEventDispatcherEvents::ENTITY_PRE_SAVE => 'entityPreSave',
      HookEventDispatcherEvents::ENTITY_INSERT => 'entityInsert',
      HookEventDispatcherEvents::ENTITY_UPDATE => 'entityUpdate',
      HookEventDispatcherEvents::ENTITY_PRE_DELETE => 'entityPreDelete',
      HookEventDispatcherEvents::ENTITY_DELETE => 'entityDelete',
    ];
  }

}
