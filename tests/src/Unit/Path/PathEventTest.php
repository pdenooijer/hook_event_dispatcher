<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Path;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;

/**
 * Class PathEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Form
 */
class PathEventTest extends TestCase {

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
   * Test PathDeleteEvent.
   */
  public function testPathDeleteEvent() {
    $source = 'testSource';
    $alias = 'testAlias';
    $langcode = 'NL';
    $pid = 1337;
    $path = [
      'source' => $source,
      'alias' => $alias,
      'langcode' => $langcode,
      'pid' => $pid,
      'redirect' => TRUE,
    ];

    hook_event_dispatcher_path_delete($path);

    /* @var \Drupal\hook_event_dispatcher\Event\Path\PathDeleteEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherEvents::PATH_DELETE);
    $this->assertEquals($source, $event->getSource());
    $this->assertEquals($alias, $event->getAlias());
    $this->assertEquals($langcode, $event->getLangcode());
    $this->assertEquals($pid, $event->getPid());
    $this->assertTrue($event->isRedirect());
  }

  /**
   * Test PathInsertEvent.
   */
  public function testPathInsertEvent() {
    $source = 'testSource';
    $alias = 'testAlias';
    $langcode = 'NL';
    $pid = 1337;
    $path = [
      'source' => $source,
      'alias' => $alias,
      'langcode' => $langcode,
      'pid' => $pid,
    ];

    hook_event_dispatcher_path_insert($path);

    /* @var \Drupal\hook_event_dispatcher\Event\Path\PathInsertEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherEvents::PATH_INSERT);
    $this->assertEquals($source, $event->getSource());
    $this->assertEquals($alias, $event->getAlias());
    $this->assertEquals($langcode, $event->getLangcode());
    $this->assertEquals($pid, $event->getPid());
  }

  /**
   * Test PathUpdateEvent.
   */
  public function testPathUpdateEvent() {
    $source = 'testSource';
    $alias = 'testAlias';
    $langcode = 'NL';
    $pid = 1337;
    $path = [
      'source' => $source,
      'alias' => $alias,
      'langcode' => $langcode,
      'pid' => $pid,
    ];

    hook_event_dispatcher_path_update($path);

    /* @var \Drupal\hook_event_dispatcher\Event\Path\PathUpdateEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherEvents::PATH_UPDATE);
    $this->assertEquals($source, $event->getSource());
    $this->assertEquals($alias, $event->getAlias());
    $this->assertEquals($langcode, $event->getLangcode());
    $this->assertEquals($pid, $event->getPid());
  }

  /**
   * Test with empty path array.
   */
  public function testWithEmptyPath() {
    $this->manager->setMaxEventCount(0);

    hook_event_dispatcher_path_delete([]);
    hook_event_dispatcher_path_insert([]);
    hook_event_dispatcher_path_update([]);
  }

}
