<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Views;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\Views\ViewsDataAlterEvent;
use Drupal\hook_event_dispatcher\Event\Views\ViewsDataEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class ViewDataEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Views
 *
 * @group hook_event_dispatcher
 */
class ViewDataEventTest extends UnitTestCase {

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

}
