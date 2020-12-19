<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Block;

use Drupal;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\core_event_dispatcher\Event\Block\BlockBuildAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function core_event_dispatcher_block_build_alter;

/**
 * Class BlockEventTest.
 *
 * @group hook_event_dispatcher
 */
class BlockEventTest extends TestCase {

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
   * Test the BlockBuildAlterEvent.
   */
  public function testBlockBuildAlterEvent(): void {
    $build = $expectedBuild = ['test' => 'build'];
    $block = $this->createMock(BlockPluginInterface::class);

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::BLOCK_BUILD_ALTER => static function (BlockBuildAlterEvent $event) {
        $build = &$event->getBuild();
        $build['other'] = 'some_build';
      },
    ]);
    $expectedBuild['other'] = 'some_build';

    core_event_dispatcher_block_build_alter($build, $block);

    /** @var \Drupal\core_event_dispatcher\Event\Block\BlockBuildAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::BLOCK_BUILD_ALTER);
    self::assertSame($expectedBuild, $event->getBuild());
    self::assertSame($expectedBuild, $build);
    self::assertSame($block, $event->getBlock());
  }

}
