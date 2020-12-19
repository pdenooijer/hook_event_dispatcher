<?php

namespace Drupal\Tests\views_event_dispatcher\Unit\Views;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\views_event_dispatcher\Event\Views\ViewsDataAlterEvent;
use Drupal\views_event_dispatcher\Event\Views\ViewsDataEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function views_event_dispatcher_views_data;
use function views_event_dispatcher_views_data_alter;

/**
 * Class ViewDataEventTest.
 *
 * @group views_event_dispatcher
 */
class ViewDataEventTest extends TestCase {

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
   * ViewsDataEvent test.
   */
  public function testViewsDataEvent(): void {
    $data = [
      'test' => [
        'test_array_data',
      ],
    ];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::VIEWS_DATA => static function (ViewsDataEvent $event) use ($data) {
        $event->addData($data);
      },
    ]);

    $result = views_event_dispatcher_views_data();

    self::assertSame($data, $result);
  }

  /**
   * ViewsDataEvent multiple adds test.
   */
  public function testViewsDataEventMultipleAdds(): void {
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
      HookEventDispatcherInterface::VIEWS_DATA => static function (ViewsDataEvent $event) use ($data1, $data2, $data3) {
        $event->addData($data1);
        $event->addData($data2);
        $event->addData($data3);
      },
    ]);

    $result = views_event_dispatcher_views_data();

    $expectedResult = [
      'test' => [
        'test_array_data',
        'other_test_array_data',
      ],
      'some' => [
        'other_data',
      ],
    ];
    self::assertSame($expectedResult, $result);
  }

  /**
   * ViewsDataAlterEvent test.
   */
  public function testViewsDataAlterEvent(): void {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::VIEWS_DATA_ALTER => static function (ViewsDataAlterEvent $event) {
        $data = &$event->getData();
        $data['test']['other_test'] = ['some_data'];
      },
    ]);

    $data = $expectedData = [
      'test' => [
        'test' => 'test_array_data',
      ],
    ];
    views_event_dispatcher_views_data_alter($data);

    $expectedData['test']['other_test'] = ['some_data'];
    self::assertSame($expectedData, $data);
  }

}
