<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Views;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\views\ViewExecutable;
use PHPUnit\Framework\TestCase;

/**
 * Class ViewEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Views
 *
 * @group hook_event_dispatcher
 */
class ViewEventTest extends TestCase {

  /**
   * The manager.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy
   */
  private $manager;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    \Drupal::setContainer($builder);
  }

  /**
   * Pre build event.
   */
  public function testPreBuildEvent() {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->getMock(ViewExecutable::class);

    hook_event_dispatcher_views_pre_build($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherEvents::VIEWS_PRE_BUILD);
    $this->assertEquals($view, $event->getView());
  }

  /**
   * Post build event.
   */
  public function testPostBuildEvent() {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->getMock(ViewExecutable::class);

    hook_event_dispatcher_views_post_build($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherEvents::VIEWS_POST_BUILD);
    $this->assertEquals($view, $event->getView());
  }

  /**
   * Pre execute event.
   */
  public function testPreExecuteEvent() {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->getMock(ViewExecutable::class);

    hook_event_dispatcher_views_pre_execute($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherEvents::VIEWS_PRE_EXECUTE);
    $this->assertEquals($view, $event->getView());
  }

  /**
   * Post execute event.
   */
  public function testPostExecuteEvent() {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->getMock(ViewExecutable::class);

    hook_event_dispatcher_views_post_execute($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherEvents::VIEWS_POST_EXECUTE);
    $this->assertEquals($view, $event->getView());
  }

}
