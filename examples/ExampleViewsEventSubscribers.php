<?php

namespace Drupal\hook_event_dispatcher;

use Drupal\views_event_dispatcher\Event\Views\ViewsPostBuildEvent;
use Drupal\views_event_dispatcher\Event\Views\ViewsPostExecuteEvent;
use Drupal\views_event_dispatcher\Event\Views\ViewsPostRenderEvent;
use Drupal\views_event_dispatcher\Event\Views\ViewsPreBuildEvent;
use Drupal\views_event_dispatcher\Event\Views\ViewsPreExecuteEvent;
use Drupal\views_event_dispatcher\Event\Views\ViewsPreRenderEvent;
use Drupal\views_event_dispatcher\Event\Views\ViewsPreViewEvent;
use Drupal\views_event_dispatcher\Event\Views\ViewsQueryAlterEvent;
use Drupal\views_event_dispatcher\Event\Views\ViewsQuerySubstitutionsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExampleViewsEventSubscribers.
 *
 * Don't forget to define your class as a service and tag it as
 * an "event_subscriber":
 *
 * services:
 *  hook_event_dispatcher.example_views_subscribers:
 *   class: Drupal\hook_event_dispatcher\ExampleViewsEventSubscribers
 *   tags:
 *     - { name: event_subscriber }
 */
class ExampleViewsEventSubscribers implements EventSubscriberInterface {

  /**
   * Pre view event handler.
   *
   * @param \Drupal\views_event_dispatcher\Event\Views\ViewsPreViewEvent $event
   *   The event.
   */
  public function preView(ViewsPreViewEvent $event): void {
    $args = &$event->getArgs();

    // Do something with the arguments.
    $args[0] = 'custom value';
  }

  /**
   * Pre build event handler.
   *
   * @param \Drupal\views_event_dispatcher\Event\Views\ViewsPreBuildEvent $event
   *   The event.
   */
  public function preBuild(ViewsPreBuildEvent $event): void {
    $view = $event->getView();

    // Do something with the view.
    $view->setArguments(['test']);
  }

  /**
   * Query alter event handler.
   *
   * @param \Drupal\views_event_dispatcher\Event\Views\ViewsQueryAlterEvent $event
   *   The event.
   */
  public function queryAlter(ViewsQueryAlterEvent $event): void {
    $query = $event->getQuery();

    // Do something with the query.
    $query->setLimit(10);
  }

  /**
   * Query substitutions event handler.
   *
   * @param \Drupal\views_event_dispatcher\Event\Views\ViewsQuerySubstitutionsEvent $event
   *   The event.
   */
  public function querySubstitutions(ViewsQuerySubstitutionsEvent $event): void {
    $event->addSubstitution('***CURRENT_TIME***', \Drupal::time()->getRequestTime());
  }

  /**
   * Post build event handler.
   *
   * @param \Drupal\views_event_dispatcher\Event\Views\ViewsPostBuildEvent $event
   *   The event.
   */
  public function postBuild(ViewsPostBuildEvent $event): void {
    $view = $event->getView();

    // Do something with the view.
    $view->build_info;
  }

  /**
   * Pre execute event handler.
   *
   * @param \Drupal\views_event_dispatcher\Event\Views\ViewsPreExecuteEvent $event
   *   The event.
   */
  public function preExecute(ViewsPreExecuteEvent $event): void {
    $view = $event->getView();

    // Do something with the view.
    $view->setArguments(['test']);
  }

  /**
   * Post execute event handler.
   *
   * @param \Drupal\views_event_dispatcher\Event\Views\ViewsPostExecuteEvent $event
   *   The event.
   */
  public function postExecute(ViewsPostExecuteEvent $event): void {
    $view = $event->getView();

    // Do something with the view.
    $view->build_info;
  }

  /**
   * Pre render event handler.
   *
   * @param \Drupal\views_event_dispatcher\Event\Views\ViewsPreRenderEvent $event
   *   The event.
   */
  public function preRender(ViewsPreRenderEvent $event): void {
    $view = $event->getView();

    // Do something with the view.
    $view->setArguments(['test']);
  }

  /**
   * Post render event handler.
   *
   * @param \Drupal\views_event_dispatcher\Event\Views\ViewsPostRenderEvent $event
   *   The event.
   */
  public function postRender(ViewsPostRenderEvent $event): void {
    $cache = $event->getCache();

    // Do something with the cache settings.
    $cache->options['results_lifespan'] = 0;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
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
