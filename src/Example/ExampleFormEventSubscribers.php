<?php

namespace Drupal\hook_event_dispatcher\Example;

use Drupal\hook_event_dispatcher\Event\Form\FormAlterEvent;
use Drupal\hook_event_dispatcher\Event\Form\FormBaseAlterEvent;
use Drupal\hook_event_dispatcher\Event\Form\FormIdAlterEvent;
use Drupal\hook_event_dispatcher\Event\Form\WidgetFormAlterEvent;
use Drupal\hook_event_dispatcher\Event\Form\WidgetTypeFormAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExampleFormEventSubscribers.
 *
 * Don't forget to define your class as a service and tag it as
 * an "event_subscriber":
 *
 * services:
 *   hook_event_dispatcher.example_form_subscribers:
 *   class: '\Drupal\hook_event_dispatcher\Example\ExampleFormEventSubscribers'
 *   tags:
 *     - { name: 'event_subscriber' }
 */
class ExampleFormEventSubscribers implements EventSubscriberInterface {

  /**
   * Alter form.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Form\FormAlterEvent $event
   *   The event.
   */
  public function alterForm(FormAlterEvent $event) {
    $form = &$event->getForm();

    $form['extra_markup'] = [
      '#markup' => 'This is really cool markup',
    ];
  }

  /**
   * Alter search form.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Form\FormIdAlterEvent $event
   *   The event.
   */
  public function alterSearchForm(FormIdAlterEvent $event) {
    $form = &$event->getForm();
    // Add placeholder.
    $form['keys']['#attributes']['placeholder'] = 'Search some things';
  }

  /**
   * Alter node form.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Form\FormBaseAlterEvent $event
   *   The event.
   */
  public function alterNodeForm(FormBaseAlterEvent $event) {
    $form = &$event->getForm();
    $form['title']['widget'][0]['value']['#title'] = 'A new title!';
  }

  /**
   * Alter widget form.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Form\WidgetFormAlterEvent $event
   *   The event.
   */
  public function alterWidgetForm(WidgetFormAlterEvent $event) {
    $element = &$event->getElement();
    $element['extra_field'] = [
      '#type' => 'textfield',
      '#title' => 'I am an extra field!',
    ];
  }

  /**
   * Alter widget string text field.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Form\WidgetTypeFormAlterEvent $event
   *   The event.
   */
  public function alterWidgetStringTextField(WidgetTypeFormAlterEvent $event) {
    $element = &$event->getElement();
    // Do something cool.
    $element['special_label'] = [
      'type' => 'label',
      'label' => 'Extra special label',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      HookEventDispatcherInterface::FORM_ALTER => 'alterForm',
      // React on "search_block_form" form.
      'hook_event_dispatcher.form_search_block_form.alter' => 'alterSearchForm',
      // React on al forms with base id "node_form".
      'hook_event_dispatcher.form_base_node_form.alter' => 'alterNodeForm',
      'hook_event_dispatcher.widget_string_textfield.alter' => 'alterWidgetStringTextField',
    ];
  }

}
