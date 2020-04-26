<?php

namespace Drupal\hook_event_dispatcher;

use Drupal\core_event_dispatcher\Event\Entity\EntityExtraFieldInfoAlterEvent;
use Drupal\core_event_dispatcher\Event\Entity\EntityExtraFieldInfoEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExampleEntityExtraFieldInfoSubscribers.
 *
 * Don't forget to define your class as a service and tag it as
 * an "event_subscriber":
 *
 * services:
 *  hook_event_dispatcher.example_entity_extra_field_info_subscribers:
 *   class: Drupal\hook_event_dispatcher\ExampleEntityExtraFieldInfoSubscribers
 * tags:
 *     - { name: event_subscriber }
 */
class ExampleEntityExtraFieldInfoSubscribers implements EventSubscriberInterface {

  /**
   * Entity extra field info.
   *
   * @param \Drupal\core_event_dispatcher\Event\Entity\EntityExtraFieldInfoEvent $event
   *   The event.
   */
  public function fieldInfo(EntityExtraFieldInfoEvent $event): void {
    // Set the field info directly.
    $fieldInfo = [];
    $event->setFieldInfo($fieldInfo);

    $entityType = 'node';
    $bundle = 'page';
    $fieldName = 'field_test';
    $testFieldInfo = [];
    // Add a single display info.
    $event->addDisplayFieldInfo($entityType, $bundle, $fieldName, $testFieldInfo);

    // Add a single form info.
    $event->addFormFieldInfo($entityType, $bundle, $fieldName, $testFieldInfo);
  }

  /**
   * Entity extra field info.
   *
   * @param \Drupal\core_event_dispatcher\Event\Entity\EntityExtraFieldInfoAlterEvent $event
   *   The event.
   */
  public function fieldInfoAlter(EntityExtraFieldInfoAlterEvent $event): void {
    $fieldInfo = &$event->getFieldInfo();

    // Manipulate the field info.
    $fieldInfo['node']['test']['display']['field_test']['weight'] = -20;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      HookEventDispatcherInterface::ENTITY_EXTRA_FIELD_INFO => 'fieldInfo',
      HookEventDispatcherInterface::ENTITY_EXTRA_FIELD_INFO_ALTER => 'fieldInfoAlter',
    ];
  }

}
