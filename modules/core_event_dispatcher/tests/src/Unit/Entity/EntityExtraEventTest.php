<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Entity;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\core_event_dispatcher\Event\Entity\EntityExtraFieldInfoAlterEvent;
use Drupal\core_event_dispatcher\Event\Entity\EntityExtraFieldInfoEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function core_event_dispatcher_entity_extra_field_info;
use function core_event_dispatcher_entity_extra_field_info_alter;

/**
 * Class EntityExtraEventTest.
 *
 * @group core_event_dispatcher
 */
class EntityExtraEventTest extends TestCase {

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
   * Test EntityExtraFieldInfoEvent with helper functions.
   */
  public function testEntityExtraFieldInfoEventWithHelperFunctions(): void {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_EXTRA_FIELD_INFO => static function (EntityExtraFieldInfoEvent $event) {
        $event->addDisplayFieldInfo('node', 'test', 'field_test', ['test' => 'node']);
        $event->addFormFieldInfo('entity', 'test_entity', 'field_node', ['test' => 'entity']);
      },
    ]);

    $expectedFieldInfo = [
      'node' => [
        'test' => [
          'display' => [
            'field_test' => [
              'test' => 'node',
            ],
          ],
        ],
      ],
      'entity' => [
        'test_entity' => [
          'form' => [
            'field_node' => [
              'test' => 'entity',
            ],
          ],
        ],
      ],
    ];
    $hookFieldInfoResult = core_event_dispatcher_entity_extra_field_info();
    self::assertSame($expectedFieldInfo, $hookFieldInfoResult);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityExtraFieldInfoEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_EXTRA_FIELD_INFO);
    self::assertSame($expectedFieldInfo, $event->getFieldInfo());
  }

  /**
   * Test EntityExtraFieldInfoEvent with set function.
   */
  public function testEntityExtraFieldInfoEventWithSetFunction(): void {
    $fieldInfo = [
      'node' => [
        'test' => [
          'display' => [
            'field_test' => [
              'test' => 'node',
            ],
          ],
        ],
      ],
      'entity' => [
        'test_entity' => [
          'form' => [
            'field_node' => [
              'test' => 'entity',
            ],
          ],
        ],
      ],
    ];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_EXTRA_FIELD_INFO => static function (EntityExtraFieldInfoEvent $event) use ($fieldInfo) {
        $event->setFieldInfo($fieldInfo);
      },
    ]);

    $hookFieldInfoResult = core_event_dispatcher_entity_extra_field_info();
    self::assertSame($fieldInfo, $hookFieldInfoResult);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityExtraFieldInfoEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_EXTRA_FIELD_INFO);
    self::assertSame($fieldInfo, $event->getFieldInfo());
  }

  /**
   * Test EntityExtraFieldInfoAlterEvent.
   */
  public function testEntityExtraFieldInfoAlterEvent(): void {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_EXTRA_FIELD_INFO_ALTER => static function (EntityExtraFieldInfoAlterEvent $event) {
        $info = &$event->getFieldInfo();
        $info['taxonomy_term']['sheep']['display']['field_herd']['sheep'] = 'herd';
      },
    ]);

    $fieldInfo = $expectedFieldInfo = [
      'node' => [
        'test' => [
          'display' => [
            'field_test' => [
              'test' => 'node',
            ],
          ],
        ],
      ],
      'entity' => [
        'test_entity' => [
          'form' => [
            'field_node' => [
              'test' => 'entity',
            ],
          ],
        ],
      ],
    ];
    $expectedFieldInfo['taxonomy_term']['sheep']['display']['field_herd']['sheep'] = 'herd';

    core_event_dispatcher_entity_extra_field_info_alter($fieldInfo);

    /** @var \Drupal\core_event_dispatcher\Event\Entity\EntityExtraFieldInfoAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_EXTRA_FIELD_INFO_ALTER);
    self::assertSame($expectedFieldInfo, $event->getFieldInfo());
    self::assertSame($expectedFieldInfo, $fieldInfo);
  }

}
