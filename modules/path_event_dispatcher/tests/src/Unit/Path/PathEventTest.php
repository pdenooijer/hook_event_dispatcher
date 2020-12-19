<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Path;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function path_event_dispatcher_path_delete;
use function path_event_dispatcher_path_insert;
use function path_event_dispatcher_path_update;

/**
 * Class PathEventTest.
 *
 * @group path_event_dispatcher
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
  public function setUp(): void {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    Drupal::setContainer($builder);
  }

  /**
   * Test PathDeleteEvent.
   */
  public function testPathDeleteEvent(): void {
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

    path_event_dispatcher_path_delete($path);

    /** @var \Drupal\path_event_dispatcher\Event\Path\PathDeleteEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::PATH_DELETE);
    self::assertSame($source, $event->getSource());
    self::assertSame($alias, $event->getAlias());
    self::assertSame($langcode, $event->getLangcode());
    self::assertSame($pid, $event->getPid());
    self::assertTrue($event->isRedirect());
  }

  /**
   * Test PathDeleteEvent.
   */
  public function testPathDeleteEventWithoutRedirect(): void {
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

    path_event_dispatcher_path_delete($path);

    /** @var \Drupal\path_event_dispatcher\Event\Path\PathDeleteEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::PATH_DELETE);
    self::assertSame($source, $event->getSource());
    self::assertSame($alias, $event->getAlias());
    self::assertSame($langcode, $event->getLangcode());
    self::assertSame($pid, $event->getPid());
    self::assertFalse($event->isRedirect());
  }

  /**
   * Test PathInsertEvent.
   */
  public function testPathInsertEvent(): void {
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

    path_event_dispatcher_path_insert($path);

    /** @var \Drupal\path_event_dispatcher\Event\Path\PathInsertEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::PATH_INSERT);
    self::assertSame($source, $event->getSource());
    self::assertSame($alias, $event->getAlias());
    self::assertSame($langcode, $event->getLangcode());
    self::assertSame($pid, $event->getPid());
  }

  /**
   * Test PathUpdateEvent.
   */
  public function testPathUpdateEvent(): void {
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

    path_event_dispatcher_path_update($path);

    /** @var \Drupal\path_event_dispatcher\Event\Path\PathUpdateEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::PATH_UPDATE);
    self::assertSame($source, $event->getSource());
    self::assertSame($alias, $event->getAlias());
    self::assertSame($langcode, $event->getLangcode());
    self::assertSame($pid, $event->getPid());
  }

}
