<?php

namespace Drupal\hook_event_dispatcher\Example;

use Drupal\hook_event_dispatcher\Event\Views\ViewsPostBuildEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsPostExecuteEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsPreExecuteEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExampleViewsEventSubscribers.
 *
 * Don't forget to define your class as a service and tag it as
 * an "event_subscriber":
 *
 * services:
 *   hook_event_dispatcher.example_views_subscribers:
 *   class: '\Drupal\hook_event_dispatcher\Example\ExampleViewsEventSubscribers'
 *   tags:
 *     - { name: 'event_subscriber' }
 */
class ExampleViewsEventSubscribers implements EventSubscriberInterface {

  /**
   * Pre execute event handler.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Views\ViewsPreExecuteEvent $event
   *   The event.
   */
  public function preExecute(ViewsPreExecuteEvent $event) {
    $view = $event->getView();

    // Do something with the view.
    $view->setArguments(['test']);
  }

  /**
   * Post execute event handler.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Views\ViewsPostExecuteEvent $event
   *   The event.
   */
  public function postExecute(ViewsPostExecuteEvent $event) {
    $view = $event->getView();

    // Do something with the view.
    $view->build_info;
  }

  /**
   * Pre execute event handler.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent $event
   *   The event.
   */
  public function preBuild(ViewsPreBuildEvent $event) {
    $view = $event->getView();

    // Do something with the view.
    $view->setArguments(['test']);
  }

  /**
   * Post execute event handler.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Views\ViewsPostBuildEvent $event
   *   The event.
   */
  public function postBuild(ViewsPostBuildEvent $event) {
    $view = $event->getView();

    // Do something with the view.
    $view->build_info;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      HookEventDispatcherInterface::VIEWS_PRE_BUILD => 'preBuild',
      HookEventDispatcherInterface::VIEWS_POST_BUILD => 'postBuild',
      HookEventDispatcherInterface::VIEWS_PRE_EXECUTE => 'preExecute',
      HookEventDispatcherInterface::VIEWS_POST_EXECUTE => 'postExecute',
    ];
  }

}
