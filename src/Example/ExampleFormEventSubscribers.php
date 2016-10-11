<?php
/**
 * Don't forget to define your class as a service and tag it as "event_subscriber":
 *
 * services:
 *   hook_event_dispatcher.example_form_subscribers:
 *   class: '\Drupal\hook_event_dispatcher\Example\ExampleFormEventSubscribers'
 *   tags:
 *     - { name: 'event_subscriber' }
 */
namespace Drupal\hook_event_dispatcher\Example;


use Drupal\hook_event_dispatcher\Event\Form\FormAlterEvent;
use Drupal\hook_event_dispatcher\Event\Form\FormIdAlterEvent;
use Drupal\hook_event_dispatcher\Event\Form\WidgetFormAlterEvent;
use Drupal\hook_event_dispatcher\Event\Form\WidgetTypeFormAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExampleFormEventSubscribers
 * @package Drupal\hook_event_dispatcher\Example
 */
class ExampleFormEventSubscribers implements EventSubscriberInterface {

  /**
   * @param \Drupal\hook_event_dispatcher\Event\Form\FormAlterEvent $event
   */
  public function alterForm(FormAlterEvent $event) {
    $form = $event->getForm();

    $form['extra_markup'] = [
      '#markup' => 'This is really cool markup',
    ];

    $event->setForm($form);
  }

  /**
   * @param \Drupal\hook_event_dispatcher\Event\Form\FormIdAlterEvent $event
   */
  public function alterSearchForm(FormIdAlterEvent $event) {
    $form = $event->getForm();
    // Add placeholder.
    $form['keys']['#attributes']['placeholder'] = 'Search some things';
    $event->setForm($form);
  }

  /**
   * @param \Drupal\hook_event_dispatcher\Event\Form\WidgetFormAlterEvent $event
   */
  public function alterWidgetForm(WidgetFormAlterEvent $event) {
    $element = $event->getElement();
    $element['extra_field'] = [
      '#type' => 'textfield',
      '#title' => 'I am an extra field!'
    ];

    $event->setElement($element);
  }

  /**
   * @param \Drupal\hook_event_dispatcher\Event\Form\WidgetTypeFormAlterEvent $event
   */
  public function alterWidgetStringTextField(WidgetTypeFormAlterEvent $event) {
    $element = $event->getElement();
    // Do something cool.
    $event->setElement($element);
  }

  /**
   * @inheritdoc
   */
  static function getSubscribedEvents() {
    return [
      HookEventDispatcherEvents::FORM_ALTER => [
        ['alterForm'],
      ],
      // react on "search_block_form" form.
      'hook_event_dispatcher.form_search_block_form.alter' => [
        ['alterSearchForm'],
      ],
      HookEventDispatcherEvents::WIDGET_FORM_ALTER => [
        ['alterWidgetForm'],
      ],
      'hook_event_dispatcher.widget_string_textfield.alter' => [
        ['alterWidgetStringTextField'],
      ],
    ];
  }

}