<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Block;

use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

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
  public function setUp() {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    \Drupal::setContainer($builder);
  }

  /**
   * Test the BlockBuildAlterEvent.
   */
  public function testBlockBuildAlterEvent() {
    $build = ['test' => 'build'];
    $block = $this->createMock(BlockPluginInterface::class);

    hook_event_dispatcher_block_build_alter($build, $block);

    /* @var \Drupal\hook_event_dispatcher\Event\Block\BlockBuildAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::BLOCK_BUILD_ALTER);
    $this->assertEquals($build, $event->getBuild());
    $this->assertEquals($block, $event->getBlock());

    $newBuild = ['newBuild'];
    $event->setBuild($newBuild);
    $this->assertEquals($newBuild, $event->getBuild());
  }

}
