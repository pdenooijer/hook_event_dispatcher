<?php

namespace Drupal\hook_event_dispatcher\Example;

use Drupal\hook_event_dispatcher\Event\Views\ViewsPostBuildEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsPostExecuteEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsPostRenderEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsPreExecuteEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsPreRenderEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsPreViewEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsQueryAlterEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsQuerySubstitutionsEvent;
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
   * Pre view event handler.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Views\ViewsPreViewEvent $event
   *   The event.
   */
  public function preView(ViewsPreViewEvent $event) {
    $view = $event->getView();
    $display_id = $event->getDisplayId();
    $args = &$event->getArgs();

    // Do something with the arguments.
    $args[0] = 'custom value';
  }

  /**
   * Pre build event handler.
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
   * Query alter event handler.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Views\ViewsQueryAlterEvent $event
   *   The event.
   */
  public function queryAlter(ViewsQueryAlterEvent $event) {
    $view = $event->getView();
    $query = $event->getQuery();

    // Do something with the query.
  }

  /**
   * Query substitutions event handler.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Views\ViewsQuerySubstitutionsEvent $event
   *   The event.
   *
   * @return array
   *   An associative array where each key is a string to be replaced, and the
   *   corresponding value is its replacement. The strings to replace are often
   *   surrounded with '***', as illustrated in the example implementation, to
   *   avoid collisions with other values in the query.
   */
  public function querySubstitutions(ViewsQuerySubstitutionsEvent $event) {
    $view = $event->getView();

    return array(
      '***CURRENT_TIME***' => \Drupal::time()->getRequestTime(),
    );
  }

  /**
   * Post build event handler.
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
   * Pre render event handler.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Views\ViewsPreRenderEvent $event
   *   The event.
   */
  public function preRender(ViewsPreRenderEvent $event) {
    $view = $event->getView();

    // Do something with the view.
    $view->setArguments(['test']);
  }

  /**
   * Post render event handler.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Views\ViewsPostRenderEvent $event
   *   The event.
   */
  public function postRender(ViewsPostRenderEvent $event) {
    $view = $event->getView();
    $output = &$event->getOutput();
    $cache = $event->getCache();

    // Do something with the cache settings.
    $cache->options['results_lifespan'] = 0;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // In order of execution.
    return [
      HookEventDispatcherInterface::VIEWS_PRE_VIEW => 'preView',
      HookEventDispatcherInterface::VIEWS_PRE_BUILD => 'preBuild',
      HookEventDispatcherInterface::VIEWS_QUERY_ALTER => 'queryAlter',
      HookEventDispatcherInterface::VIEWS_QUERY_SUBSTITUTIONS => 'querySubstitutions',
      HookEventDispatcherInterface::VIEWS_POST_BUILD => 'postBuild',
      HookEventDispatcherInterface::VIEWS_PRE_EXECUTE => 'preExecute',
      HookEventDispatcherInterface::VIEWS_POST_EXECUTE => 'postExecute',
      HookEventDispatcherInterface::VIEWS_PRE_RENDER => 'preRender',
      HookEventDispatcherInterface::VIEWS_POST_RENDER => 'postRender',
    ];
  }

}
