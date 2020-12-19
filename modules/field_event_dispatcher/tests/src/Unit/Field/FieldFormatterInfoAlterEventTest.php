<?php

namespace Drupal\Tests\field_event_dispatcher\Unit\Field;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\field_event_dispatcher\Event\Field\FieldFormatterInfoAlterEvent;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function field_event_dispatcher_field_formatter_info_alter;

/**
 * Class FieldFormatterInfoAlterEventTest.
 *
 * @group field_event_dispatcher
 */
class FieldFormatterInfoAlterEventTest extends TestCase {

  /**
   * The manager.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy
   */
  private $manager;

  /**
   * Sets up the test.
   */
  public function setUp(): void {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    Drupal::setContainer($builder);
  }

  /**
   * FieldFormatterInfoAlterEvent array alter test.
   *
   * This tests altering the field formatter type definitions array.
   */
  public function testInfoAlter() {
    $info = $expectedInfo = [
      'image' => [
        'id' => 'image',
        'class' => 'Drupal\image\Plugin\Field\FieldFormatter\ImageFormatter',
      ],
    ];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::FIELD_FORMATTER_INFO_ALTER => static function (
        FieldFormatterInfoAlterEvent $event
      ) {
        $info = &$event->getInfo();

        $info['image']['class'] = 'Drupal\another_module\Plugin\Field\FieldFormatter\ImageFormatter';
      },
    ]);

    // Run the procedural hook which should trigger the above handler.
    field_event_dispatcher_field_formatter_info_alter($info);

    /** @var \Drupal\field_event_dispatcher\Event\Field\FieldFormatterInfoAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(
      HookEventDispatcherInterface::FIELD_FORMATTER_INFO_ALTER
    );

    self::assertSame($info, $event->getInfo());

    $expectedInfo['image']['class'] = 'Drupal\another_module\Plugin\Field\FieldFormatter\ImageFormatter';

    self::assertSame($expectedInfo, $info);
  }

}
