<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Views;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\Views\ViewsDataAlterEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsDataEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsPostRenderEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsPreRenderEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsPreViewEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\views\Plugin\views\cache\CachePluginBase;
use Drupal\views\Plugin\views\query\QueryPluginBase;
use Drupal\views\ViewExecutable;
use Drupal\Tests\UnitTestCase;

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
   * ViewsDataEvent test.
   */
  public function testViewsDataEvent() {
    $data = [
      'test' => [
        'test_array_data',
      ],
    ];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::VIEWS_DATA => function (ViewsDataEvent $event) use ($data) {
        $event->addData($data);
      },
    ]);

    $result = hook_event_dispatcher_views_data();

    $this->assertSame($data, $result);
  }

  /**
   * ViewsDataEvent multiple adds test.
   */
  public function testViewsDataEventMultipleAdds() {
    $data1 = [
      'test' => [
        'test_array_data',
      ],
    ];

    $data2 = [
      'test' => [
        'other_test_array_data',
      ],
    ];

    $data3 = [
      'some' => [
        'other_data',
      ],
    ];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::VIEWS_DATA => function (ViewsDataEvent $event) use ($data1, $data2, $data3) {
        $event->addData($data1);
        $event->addData($data2);
        $event->addData($data3);
      },
    ]);

    $result = hook_event_dispatcher_views_data();

    $expectedResult = [
      'test' => [
        'test_array_data',
        'other_test_array_data',
      ],
      'some' => [
        'other_data',
      ],
    ];
    $this->assertSame($expectedResult, $result);
  }

  /**
   * ViewsDataAlterEvent by reference test.
   */
  public function testViewsDataAlterEventByReference() {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::VIEWS_DATA_ALTER => function (ViewsDataAlterEvent $event) {
        $data = &$event->getData();
        $data['test']['other_test'] = ['some_data'];
      },
    ]);

    $data = $expectedData = [
      'test' => [
        'test' => 'test_array_data',
      ],
    ];
    hook_event_dispatcher_views_data_alter($data);

    $expectedData['test']['other_test'] = ['some_data'];
    $this->assertSame($expectedData, $data);
  }

  /**
   * ViewsDataAlterEvent by set test.
   */
  public function testViewsDataAlterEventBySet() {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::VIEWS_DATA_ALTER => function (ViewsDataAlterEvent $event) {
        $data = $event->getData();
        $data['other'] = ['other_data'];
        $event->setData($data);
      },
    ]);

    $data = $expectedData = [
      'test' => [
        'test' => 'test_array_data',
      ],
    ];
    hook_event_dispatcher_views_data_alter($data);

    $expectedData['other'] = ['other_data'];
    $this->assertSame($expectedData, $data);
  }

  /**
   * Pre view event.
   */
  public function testPreViewEvent() {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);
    $display_id = 'test';
    $args = $original_args = [
      'test',
    ];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::VIEWS_PRE_VIEW => function (ViewsPreViewEvent $event) {
        $args = &$event->getArgs();
        $args[0] = 'test2';
      },
    ]);

    hook_event_dispatcher_views_pre_view($view, $display_id, $args);

    $this->assertEquals('test2', $args[0]);
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

    hook_event_dispatcher_views_query_substitutions($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsQuerySubstitutionsEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::VIEWS_QUERY_SUBSTITUTIONS);
    $this->assertSame($view, $event->getView());
  }

}
