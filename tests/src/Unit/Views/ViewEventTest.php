<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Views;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\Views\ViewsPostRenderEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsPreViewEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsQuerySubstitutionsEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;
use Drupal\views\Plugin\views\cache\CachePluginBase;
use Drupal\views\Plugin\views\query\QueryPluginBase;
use Drupal\views\ViewExecutable;

/**
 * Class ViewEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Views
 *
 * @group hook_event_dispatcher
 */
class ViewEventTest extends UnitTestCase {

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
   * Pre view event.
   */
  public function testPreViewEvent() {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);
    $displayId = 'test';
    $arguments = [
      'test',
    ];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::VIEWS_PRE_VIEW => function (ViewsPreViewEvent $event) {
        $arguments = &$event->getArguments();
        $arguments[0] = 'test2';
      },
    ]);

    hook_event_dispatcher_views_pre_view($view, $displayId, $arguments);

    $this->assertEquals('test2', $arguments[0]);
  }

  /**
   * Pre build event.
   */
  public function testPreBuildEvent() {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);

    hook_event_dispatcher_views_pre_build($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_PRE_BUILD);
    $this->assertEquals($view, $event->getView());
  }

  /**
   * Post build event.
   */
  public function testPostBuildEvent() {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);

    hook_event_dispatcher_views_post_build($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_POST_BUILD);
    $this->assertEquals($view, $event->getView());
  }

  /**
   * Pre execute event.
   */
  public function testPreExecuteEvent() {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);

    hook_event_dispatcher_views_pre_execute($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_PRE_EXECUTE);
    $this->assertEquals($view, $event->getView());
  }

  /**
   * Post execute event.
   */
  public function testPostExecuteEvent() {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);

    hook_event_dispatcher_views_post_execute($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_POST_EXECUTE);
    $this->assertEquals($view, $event->getView());
  }

  /**
   * Pre render event.
   */
  public function testPreRender() {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);

    hook_event_dispatcher_views_pre_render($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_PRE_RENDER);
    $this->assertEquals($view, $event->getView());
  }

  /**
   * Post render event.
   */
  public function testPostRenderEvent() {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);
    $output = "<h1>test</h1>";
    /** @var \Drupal\views\Plugin\views\cache\CachePluginBase $cache */
    $cache = $this->createMock(CachePluginBase::class);
    $cache->options['results_lifespan'] = 0;

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::VIEWS_POST_RENDER => function (ViewsPostRenderEvent $event) {
        $output = &$event->getOutput();
        $output = "<h2>Test</h2>";
        $cache = $event->getCache();
        $cache->options['results_lifespan'] = 10;
      },
    ]);

    hook_event_dispatcher_views_post_render($view, $output, $cache);

    $this->assertEquals("<h2>Test</h2>", $output);
    $this->assertEquals(10, $cache->options['results_lifespan']);
  }

  /**
   * Query alter event.
   */
  public function testQueryAlterEvent() {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);
    /** @var \Drupal\views\Plugin\views\query\QueryPluginBase $query */
    $query = $this->createMock(QueryPluginBase::class);

    hook_event_dispatcher_views_query_alter($view, $query);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsQueryAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_QUERY_ALTER);
    $this->assertSame($view, $event->getView());
    $this->assertSame($query, $event->getQuery());
  }

  /**
   * Query substitutions event.
   */
  public function testQuerySubstitions() {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);
    $expected = ["test" => 1];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::VIEWS_QUERY_SUBSTITUTIONS => function (ViewsQuerySubstitutionsEvent $event) use ($expected) {
        $event->setSubstitutions($expected);
      },
    ]);

    $result = hook_event_dispatcher_views_query_substitutions($view);
    $this->assertSame($expected, $result);
  }

}
