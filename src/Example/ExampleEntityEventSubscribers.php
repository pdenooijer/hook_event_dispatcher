<?php
/**
 * Don't forget to define your class as a service and tag it as "event_subscriber":
 *
 * services:
 *   hook_event_dispatcher.example_entity_subscribers:
 *   class: '\Drupal\hook_event_dispatcher\Example\ExampleEntityEventSubscribers'
 *   tags:
 *     - { name: 'event_subscriber' }
 */
namespace Drupal\hook_event_dispatcher\Example;


use Drupal\hook_event_dispatcher\Event\Entity\EntityDeleteEvent;
use Drupal\hook_event_dispatcher\Event\Entity\EntityInsertEvent;
use Drupal\hook_event_dispatcher\Event\Entity\EntityPresaveEvent;
use Drupal\hook_event_dispatcher\Event\Entity\EntityUpdateEvent;
use Drupal\hook_event_dispatcher\Event\Entity\EntityViewEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;
use Drupal\node\NodeInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExampleEntityEventSubscribers
 * @package Drupal\hook_event_dispatcher\Example
 */
class ExampleEntityEventSubscribers implements EventSubscriberInterface {

  /**
   * @param \Drupal\hook_event_dispatcher\Event\Entity\EntityViewEvent $event
   */
  public function alterEntityView(EntityViewEvent $event) {
    $entity = $event->getEntity();

    // Only do this for entities of type Node.
    if ($entity instanceof NodeInterface) {
      $build = $event->getBuild();
      $build['extra_markup'] = [
        '#markup' => 'this is extra markup',
      ];

      $event->setBuild($build);
    }
  }

  /**
   * @param \Drupal\hook_event_dispatcher\Event\Entity\EntityPresaveEvent $event
   */
  public function hookEntityPreSave(EntityPresaveEvent $event) {
    $entity = $event->getEntity();
    $entity->title->value = 'Overwritten';
    $event->setEntity($entity);
  }

  /**
   * @param \Drupal\hook_event_dispatcher\Event\Entity\EntityInsertEvent $event
   */
  public function hookEntityInsert(EntityInsertEvent $event) {
    $entity = $event->getEntity();
    // Do some fancy stuff.
  }

  /**
   * @param \Drupal\hook_event_dispatcher\Event\Entity\EntityUpdateEvent $event
   */
  public function hookEntityUpdate(EntityUpdateEvent $event) {
    $entity = $event->getEntity();
    // Do some fancy stuff.
  }

  /**
   * @param \Drupal\hook_event_dispatcher\Event\Entity\EntityDeleteEvent $event
   */
  public function hookEntityDelete(EntityDeleteEvent $event) {
    $entity = $event->getEntity();
    // Do some fancy stuff.
  }

  /**
   * @inheritdoc
   */
  static function getSubscribedEvents() {
    return [
      HookEventDispatcherEvents::ENTITY_VIEW => [
        ['alterEntityView'],
      ],
      HookEventDispatcherEvents::ENTITY_PRE_SAVE => [
        ['hookEntityPreSave'],
      ],
      HookEventDispatcherEvents::ENTITY_INSERT => [
        ['hookEntityInsert'],
      ],
      HookEventDispatcherEvents::ENTITY_UPDATE => [
        ['hookEntityUpdate'],
      ],
      HookEventDispatcherEvents::ENTITY_DELETE => [
        ['hookEntityDelete'],
      ],
    ];
  }

}