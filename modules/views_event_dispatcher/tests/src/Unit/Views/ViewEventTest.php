<?php

namespace Drupal\Tests\views_event_dispatcher\Unit\Views;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\views\Plugin\views\cache\CachePluginBase;
use Drupal\views\Plugin\views\query\QueryPluginBase;
use Drupal\views\ViewExecutable;
use Drupal\views_event_dispatcher\Event\Views\ViewsPostRenderEvent;
use Drupal\views_event_dispatcher\Event\Views\ViewsPreViewEvent;
use Drupal\views_event_dispatcher\Event\Views\ViewsQuerySubstitutionsEvent;
use PHPUnit\Framework\TestCase;
use function views_event_dispatcher_views_post_build;
use function views_event_dispatcher_views_post_execute;
use function views_event_dispatcher_views_post_render;
use function views_event_dispatcher_views_pre_build;
use function views_event_dispatcher_views_pre_execute;
use function views_event_dispatcher_views_pre_render;
use function views_event_dispatcher_views_query_alter;
use function views_event_dispatcher_views_query_substitutions;

/**
 * Class ViewEventTest.
 *
 * @group views_event_dispatcher
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

    views_event_dispatcher_views_pre_view($view, $displayId, $arguments);

    /** @var \Drupal\views_event_dispatcher\Event\Views\ViewsPreViewEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_PRE_VIEW);
    self::assertSame($view, $event->getView());
    self::assertSame($displayId, $event->getDisplayId());
    self::assertSame('test2', $arguments[0]);
  }

  /**
   * Pre build event.
   */
  public function testPreBuildEvent(): void {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);

    views_event_dispatcher_views_pre_build($view);

    /** @var \Drupal\views_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_PRE_BUILD);
    self::assertSame($view, $event->getView());
  }

  /**
   * Post build event.
   */
  public function testPostBuildEvent(): void {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);

    views_event_dispatcher_views_post_build($view);

    /** @var \Drupal\views_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_POST_BUILD);
    self::assertSame($view, $event->getView());
  }

  /**
   * Pre execute event.
   */
  public function testPreExecuteEvent(): void {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);

    views_event_dispatcher_views_pre_execute($view);

    /** @var \Drupal\views_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_PRE_EXECUTE);
    self::assertSame($view, $event->getView());
  }

  /**
   * Post execute event.
   */
  public function testPostExecuteEvent(): void {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);

    views_event_dispatcher_views_post_execute($view);

    /** @var \Drupal\views_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_POST_EXECUTE);
    self::assertSame($view, $event->getView());
  }

  /**
   * Pre render event.
   */
  public function testPreRender(): void {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);

    views_event_dispatcher_views_pre_render($view);

    /** @var \Drupal\views_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_PRE_RENDER);
    self::assertSame($view, $event->getView());
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

    views_event_dispatcher_views_post_render($view, $output, $cache);

    $expectedOutput['#attached']['library'][] = 'test';

    /** @var \Drupal\views_event_dispatcher\Event\Views\ViewsPostRenderEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_POST_RENDER);
    self::assertSame($expectedOutput, $event->getOutput());
    self::assertSame($expectedOutput, $output);
    self::assertSame($cache, $event->getCache());
    self::assertSame(10, $cache->options['results_lifespan']);
  }

  /**
   * Query alter event.
   */
  public function testQueryAlterEvent(): void {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);
    /** @var \Drupal\views\Plugin\views\query\QueryPluginBase $query */
    $query = $this->createMock(QueryPluginBase::class);

    views_event_dispatcher_views_query_alter($view, $query);

    /** @var \Drupal\views_event_dispatcher\Event\Views\ViewsQueryAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_QUERY_ALTER);
    self::assertSame($view, $event->getView());
    self::assertSame($query, $event->getQuery());
  }

  /**
   * Query substitutions event by reference test.
   *
   * @SuppressWarnings(PHPMD.UnusedLocalVariable)
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

    $result = views_event_dispatcher_views_query_substitutions($view);

    /** @var \Drupal\views_event_dispatcher\Event\Views\ViewsQuerySubstitutionsEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_QUERY_SUBSTITUTIONS);
    self::assertSame($view, $event->getView());
    self::assertSame($expected, $event->getSubstitutions());
    self::assertSame($expected, $result);
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
    $result = views_event_dispatcher_views_query_substitutions($view);

    /** @var \Drupal\views_event_dispatcher\Event\Views\ViewsQuerySubstitutionsEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_QUERY_SUBSTITUTIONS);
    self::assertSame($view, $event->getView());
    self::assertSame($expected, $event->getSubstitutions());
    self::assertSame($expected, $result);
  }

}
