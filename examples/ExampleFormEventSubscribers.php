<?php

namespace Drupal\hook_event_dispatcher;

use Drupal\core_event_dispatcher\Event\Form\FormAlterEvent;
use Drupal\core_event_dispatcher\Event\Form\FormBaseAlterEvent;
use Drupal\core_event_dispatcher\Event\Form\FormIdAlterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExampleFormEventSubscribers.
 *
 * Don't forget to define your class as a service and tag it as
 * an "event_subscriber":
 *
 * services:
 *  hook_event_dispatcher.example_form_subscribers:
 *   class: Drupal\hook_event_dispatcher\ExampleFormEventSubscribers
 *   tags:
 *     - { name: event_subscriber }
 */
class ExampleFormEventSubscribers implements EventSubscriberInterface {

  /**
   * Alter form.
   *
   * @param \Drupal\core_event_dispatcher\Event\Form\FormAlterEvent $event
   *   The event.
   */
  public function alterForm(FormAlterEvent $event): void {
    $form = &$event->getForm();

    $form['extra_markup'] = [
      '#markup' => 'This is really cool markup',
    ];
  }

  /**
   * Alter search form.
   *
   * @param \Drupal\core_event_dispatcher\Event\Form\FormIdAlterEvent $event
   *   The event.
   */
  public function alterSearchForm(FormIdAlterEvent $event): void {
    $form = &$event->getForm();
    // Add placeholder.
    $form['keys']['#attributes']['placeholder'] = 'Search some things';
  }

  /**
   * Alter node form.
   *
   * @param \Drupal\core_event_dispatcher\Event\Form\FormBaseAlterEvent $event
   *   The event.
   */
  public function alterNodeForm(FormBaseAlterEvent $event): void {
    $form = &$event->getForm();
    $form['title']['widget'][0]['value']['#title'] = 'A new title!';
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      HookEventDispatcherInterface::FORM_ALTER => 'alterForm',
      // React on "search_block_form" form.
      'hook_event_dispatcher.form_search_block_form.alter' => 'alterSearchForm',
      // React on al forms with base id "node_form".
      'hook_event_dispatcher.form_base_node_form.alter' => 'alterNodeForm',
    ];
  }

}
