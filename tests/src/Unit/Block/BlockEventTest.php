<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Block;

use Drupal;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\Block\BlockBuildAlterEvent;
use Drupal\core_event_dispatcher\Event\Entity\EntityAccessEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;
use function hook_event_dispatcher_block_build_alter;

/**
 * Class BlockEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Block
 *
 * @group hook_event_dispatcher
 */
class BlockEventTest extends UnitTestCase {

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

    hook_event_dispatcher_block_build_alter($build, $block);

    /* @var \Drupal\hook_event_dispatcher\Event\Block\BlockBuildAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::BLOCK_BUILD_ALTER);
    $this->assertSame($expectedBuild, $event->getBuild());
    $this->assertSame($expectedBuild, $build);
    $this->assertSame($block, $event->getBlock());
  }

}
