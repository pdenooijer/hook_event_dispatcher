<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Views;

use Drupal;
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
use function hook_event_dispatcher_views_post_build;
use function hook_event_dispatcher_views_post_execute;
use function hook_event_dispatcher_views_post_render;
use function hook_event_dispatcher_views_pre_build;
use function hook_event_dispatcher_views_pre_execute;
use function hook_event_dispatcher_views_pre_render;
use function hook_event_dispatcher_views_query_alter;
use function hook_event_dispatcher_views_query_substitutions;

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
  public function setUp(): void {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    Drupal::setContainer($builder);
  }

  /**
   * Pre view event.
   */
  public function testPreViewEvent(): void {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);
    $displayId = 'test';
    $arguments = [
      'test',
    ];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::VIEWS_PRE_VIEW => static function (ViewsPreViewEvent $event) {
        $arguments = &$event->getArguments();
        $arguments[0] = 'test2';
      },
    ]);

    hook_event_dispatcher_views_pre_view($view, $displayId, $arguments);

    /** @var \Drupal\hook_event_dispatcher\Event\Views\ViewsPreViewEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_PRE_VIEW);
    $this->assertSame($view, $event->getView());
    $this->assertSame($displayId, $event->getDisplayId());
    $this->assertSame('test2', $arguments[0]);
  }

  /**
   * Pre build event.
   */
  public function testPreBuildEvent(): void {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);

    hook_event_dispatcher_views_pre_build($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_PRE_BUILD);
    $this->assertSame($view, $event->getView());
  }

  /**
   * Post build event.
   */
  public function testPostBuildEvent(): void {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);

    hook_event_dispatcher_views_post_build($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_POST_BUILD);
    $this->assertSame($view, $event->getView());
  }

  /**
   * Pre execute event.
   */
  public function testPreExecuteEvent(): void {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);

    hook_event_dispatcher_views_pre_execute($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_PRE_EXECUTE);
    $this->assertSame($view, $event->getView());
  }

  /**
   * Post execute event.
   */
  public function testPostExecuteEvent(): void {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);

    hook_event_dispatcher_views_post_execute($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_POST_EXECUTE);
    $this->assertSame($view, $event->getView());
  }

  /**
   * Pre render event.
   */
  public function testPreRender(): void {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);

    hook_event_dispatcher_views_pre_render($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_PRE_RENDER);
    $this->assertSame($view, $event->getView());
  }

  /**
   * Post render event.
   */
  public function testPostRenderEvent(): void {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);
    $output = $expectedOutput = [
      '#theme' => [
        'views_view',
      ],
      '#attached' => [
        'library' => [
          'views/views.module',
        ],
      ],
    ];
    /** @var \Drupal\views\Plugin\views\cache\CachePluginBase $cache */
    $cache = $this->createMock(CachePluginBase::class);
    $cache->options['results_lifespan'] = 0;

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::VIEWS_POST_RENDER => static function (ViewsPostRenderEvent $event) {
        $output = &$event->getOutput();
        $output['#attached']['library'][] = 'test';
        $cache = $event->getCache();
        $cache->options['results_lifespan'] = 10;
      },
    ]);

    hook_event_dispatcher_views_post_render($view, $output, $cache);

    $expectedOutput['#attached']['library'][] = 'test';

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsPostRenderEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_POST_RENDER);
    $this->assertSame($expectedOutput, $event->getOutput());
    $this->assertSame($expectedOutput, $output);
    $this->assertSame($cache, $event->getCache());
    $this->assertSame(10, $cache->options['results_lifespan']);
  }

  /**
   * Query alter event.
   */
  public function testQueryAlterEvent(): void {
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
   * Query substitutions event by reference test.
   */
  public function testQuerySubstitutionsByReference(): void {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);
    $expected = ['test' => 'other'];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::VIEWS_QUERY_SUBSTITUTIONS => static function (ViewsQuerySubstitutionsEvent $event) use ($expected) {
        $substitutions = &$event->getSubstitutions();
        $substitutions = $expected;
      },
    ]);

    $result = hook_event_dispatcher_views_query_substitutions($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsQuerySubstitutionsEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_QUERY_SUBSTITUTIONS);
    $this->assertSame($view, $event->getView());
    $this->assertSame($expected, $event->getSubstitutions());
    $this->assertSame($expected, $result);
  }

  /**
   * Query substitutions event by add test.
   */
  public function testQuerySubstitutionsByAdd(): void {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::VIEWS_QUERY_SUBSTITUTIONS => static function (ViewsQuerySubstitutionsEvent $event) {
        $event->addSubstitution('test', 'replacement');
      },
    ]);

    $expected = ['test' => 'replacement'];
    $result = hook_event_dispatcher_views_query_substitutions($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsQuerySubstitutionsEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_QUERY_SUBSTITUTIONS);
    $this->assertSame($view, $event->getView());
    $this->assertSame($expected, $event->getSubstitutions());
    $this->assertSame($expected, $result);
  }

}
