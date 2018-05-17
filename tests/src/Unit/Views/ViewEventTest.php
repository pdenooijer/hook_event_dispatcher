<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Views;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\Views\ViewsDataEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
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
      HookEventDispatcherEvents::VIEWS_DATA => function (ViewsDataEvent $event) use ($data) {
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
      HookEventDispatcherEvents::VIEWS_DATA => function (ViewsDataEvent $event) use ($data1, $data2, $data3) {
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
   * Pre build event.
   */
  public function testPreBuildEvent() {
    /** @var \Drupal\views\ViewExecutable $view */
    $view = $this->createMock(ViewExecutable::class);

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
    $view = $this->createMock(ViewExecutable::class);

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
    $view = $this->createMock(ViewExecutable::class);

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
    $view = $this->createMock(ViewExecutable::class);

    hook_event_dispatcher_views_post_execute($view);

    /* @var \Drupal\hook_event_dispatcher\Event\Views\ViewsPreBuildEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherEvents::VIEWS_POST_EXECUTE);
    $this->assertEquals($view, $event->getView());
  }

}
