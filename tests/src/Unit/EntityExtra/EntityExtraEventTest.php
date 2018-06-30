<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\EntityExtra;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\EntityExtra\EntityExtraFieldInfoAlterEvent;
use Drupal\hook_event_dispatcher\Event\EntityExtra\EntityExtraFieldInfoEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class EntityExtraEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Entity
 *
 * @group hook_event_dispatcher
 */
class EntityExtraEventTest extends UnitTestCase {

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
   * Test EntityExtraFieldInfoEvent with helper functions.
   */
  public function testEntityExtraFieldInfoEventWithHelperFunctions() {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_EXTRA_FIELD_INFO => function (EntityExtraFieldInfoEvent $event) {
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
    $hookFieldInfoResult = hook_event_dispatcher_entity_extra_field_info();
    $this->assertEquals($expectedFieldInfo, $hookFieldInfoResult);

    /* @var \Drupal\hook_event_dispatcher\Event\EntityExtra\EntityExtraFieldInfoEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_EXTRA_FIELD_INFO);
    $this->assertEquals($expectedFieldInfo, $event->getFieldInfo());
  }

  /**
   * Test EntityExtraFieldInfoEvent with set function.
   */
  public function testEntityExtraFieldInfoEventWithSetFunction() {
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
      HookEventDispatcherInterface::ENTITY_EXTRA_FIELD_INFO => function (EntityExtraFieldInfoEvent $event) use ($fieldInfo) {
        $event->setFieldInfo($fieldInfo);
      },
    ]);

    $hookFieldInfoResult = hook_event_dispatcher_entity_extra_field_info();
    $this->assertEquals($fieldInfo, $hookFieldInfoResult);

    /* @var \Drupal\hook_event_dispatcher\Event\EntityExtra\EntityExtraFieldInfoEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_EXTRA_FIELD_INFO);
    $this->assertEquals($fieldInfo, $event->getFieldInfo());
  }

  /**
   * Test EntityExtraFieldInfoAlterEvent.
   */
  public function testEntityExtraFieldInfoAlterEvent() {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::ENTITY_EXTRA_FIELD_INFO_ALTER => function (EntityExtraFieldInfoAlterEvent $event) {
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

    hook_event_dispatcher_entity_extra_field_info_alter($fieldInfo);

    /* @var \Drupal\hook_event_dispatcher\Event\EntityExtra\EntityExtraFieldInfoAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::ENTITY_EXTRA_FIELD_INFO_ALTER);
    $this->assertEquals($expectedFieldInfo, $event->getFieldInfo());
    $this->assertEquals($expectedFieldInfo, $fieldInfo);
  }

}
